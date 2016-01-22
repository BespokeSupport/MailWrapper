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
 * Class MessageConvertPhpMailerTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class MessageConvertPhpMailerTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function setUp()
    {
        if (!class_exists('PHPMailer')) {
            $this->markTestSkipped('PHPMailer not installed');
        }
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNoConverterMailgun()
    {
        MessageTransformer::convert('mailgun', null);
    }

    /**
     *
     */
    public function testToMailgun()
    {
        $message = new \PHPMailer();
        $message->addAddress('hello1@example.com');
        $message->addCC('cc1@example.com');
        $message->addCC('cc2@example.com');
        $message->addBCC('bcc1@example.com');
        $message->addBCC('bcc2@example.com');
        $message->addReplyTo('reply1@example.com');
        $message->addReplyTo('reply2@example.com');
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        MessageTransformer::convert('mailgun', $message, $transport);
        $this->assertTrue(true);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testToMailgunNoTo()
    {
        $message = new \PHPMailer();
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        MessageTransformer::convert('mailgun', $message, $transport);
        $this->assertTrue(true);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testToSwift()
    {
        $message = new \PHPMailer();
        MessageTransformer::convert('swift', $message);
    }

    /**
     *
     */
    public function testToSwiftSuccess()
    {
        $message = new \PHPMailer();
        $message->setFrom('from@example.com');
        $message->addAddress('to1@example.com');
        $message->addCC('cc1@example.com');
        $message->addBCC('bcc1@example.com');
        $message->addReplyTo('reply1@example.com');
        MessageTransformer::convert('swift', $message);
        $this->assertTrue(true);
    }
}
