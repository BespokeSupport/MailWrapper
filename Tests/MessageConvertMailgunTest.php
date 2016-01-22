<?php
/**
 * Mail Wrapper
 *
 * PHP Version 5
 *
 * @author   Richard Seymour <web@bespoke.support>
 * @license  MIT
 * @link     https://github.com/BespokeSupport/MailWrapper
 */

namespace BespokeSupport\MailWrapper\Tests;

use BespokeSupport\MailWrapper\MailgunManager;
use BespokeSupport\MailWrapper\MessageTransformer;

/**
 * Class MessageConvertMailgunTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class MessageConvertMailgunTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function testToSwiftMinimal()
    {
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        $message = $transport->batch();

        $message->setFromAddress('from@example.com');
        $message->addToRecipient('to1@example.com');
        $message->setSubject('subject');
        $message->setTextBody('content');

        MessageTransformer::convert('swift', $message, $transport);
        $this->assertTrue(true);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testToSwiftMinimalNoBody()
    {
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        $message = $transport->batch();

        $message->setFromAddress('from@example.com');
        $message->addToRecipient('to1@example.com');
        $message->setSubject('subject');

        MessageTransformer::convert('swift', $message, $transport);
        $this->assertTrue(true);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testToSwiftMinimalNoFrom()
    {
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        $message = $transport->batch();

        $message->addToRecipient('to1@example.com');
        $message->setSubject('subject');
        $message->setTextBody('content');

        MessageTransformer::convert('swift', $message, $transport);
        $this->assertTrue(true);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testToSwiftMinimalNoSubject()
    {
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        $message = $transport->batch();

        $message->setFromAddress('from@example.com');
        $message->addToRecipient('to1@example.com');
        $message->setTextBody('content');

        MessageTransformer::convert('swift', $message, $transport);
        $this->assertTrue(true);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testToSwiftMinimalNoTo()
    {
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        $message = $transport->batch();

        $message->setFromAddress('from@example.com');
        $message->setSubject('subject');
        $message->setTextBody('content');

        MessageTransformer::convert('swift', $message, $transport);
        $this->assertTrue(true);
    }

    /**
     *
     */
    public function testToSwiftOk()
    {
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        $message = $transport->batch();

        $message->setFromAddress('from@example.com');
        $message->addToRecipient('to1@example.com');
        $message->addToRecipient('to2@example.com');
        $message->addCcRecipient('cc1@example.com');
        $message->addCcRecipient('cc2@example.com');
        $message->addBccRecipient('bcc1@example.com');
        $message->addBccRecipient('bcc2@example.com');
        $message->setSubject('subject');
        $message->setTextBody('content');

        $result = MessageTransformer::convert('swift', $message, $transport);
        $this->assertTrue(true);
        $this->assertCount(2, $result->getTo());
        $this->assertCount(2, $result->getCc());
        $this->assertCount(2, $result->getBcc());
    }

}
