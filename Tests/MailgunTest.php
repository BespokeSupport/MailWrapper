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
use BespokeSupport\MailWrapper\MailManager;

/**
 * Class MailgunTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class MailgunTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testException()
    {
        $apiKey = null;
        $domain = null;
        (new MailgunManager($apiKey, $domain));
    }

    public function testValid()
    {
        $apiKey = 'key';
        $domain = 'example.com';
        $manager = new MailgunManager($apiKey, $domain);
        $this->assertInstanceOf('\BespokeSupport\MailWrapper\MailgunManager', $manager);
    }

    public function testBatch()
    {
        $apiKey = 'key';
        $domain = 'example.com';
        $manager = new MailgunManager($apiKey, $domain);
        $this->assertInstanceOf('\BespokeSupport\MailWrapper\MailgunManager', $manager);

        $batch = $manager->batch();
        $this->assertInstanceOf('\BespokeSupport\MailWrapper\MailgunMessage', $batch);

        $this->assertEquals(0, $batch->getRecipientCount('to'));
        $this->assertEquals(0, $batch->getRecipientCount('cc'));
        $this->assertEquals(0, $batch->getRecipientCount('bcc'));

        $batch->addToRecipient('hello@example.com');
        $batch->addCcRecipient('hello@example.com');
        $batch->addBccRecipient('hello@example.com');

        $this->assertEquals(1, $batch->getRecipientCount('to'));
        $this->assertEquals(1, $batch->getRecipientCount('cc'));
        $this->assertEquals(1, $batch->getRecipientCount('bcc'));
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testBatchException()
    {
        $apiKey = 'key';
        $domain = 'example.com';
        $manager = new MailgunManager($apiKey, $domain);
        $this->assertInstanceOf('\BespokeSupport\MailWrapper\MailgunManager', $manager);
        $batch = $manager->batch();
        $this->assertInstanceOf('\BespokeSupport\MailWrapper\MailgunMessage', $batch);
        $batch->getRecipientCount('ERR');
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testSendNoMessage()
    {
        $apiKey = 'key';
        $domain = 'example.com';
        $manager = new MailgunManager($apiKey, $domain);
        MailManager::sendViaMailgun($manager, null);
    }

    public function testCcBcc()
    {
        $apiKey = 'key';
        $domain = 'example.com';
        $manager = new TestMailgunNullManager($apiKey, $domain);

        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );
        $message->addCc('hello1@example.com');
        $message->addBCc('hello2@example.com');

        MailManager::sendVia($manager, $message);
    }

    public function testSend()
    {
        $apiKey = 'key';
        $domain = 'example.com';
        $manager = new TestMailgunNullManager($apiKey, $domain);

        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );

        MailManager::sendVia($manager, $message);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSendException
     */
    public function testSendException()
    {
        $apiKey = 'key';
        $domain = 'example.com';
        $manager = new TestMailgunExceptionManager($apiKey, $domain);

        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );

        MailManager::sendViaMailgun($manager, $message);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testExceedEmails()
    {
        $apiKey = 'key';
        $domain = 'example.com';
        $manager = new MailgunManager($apiKey, $domain);

        $toMails = [];

        for ($i = 0; $i <= 1003; $i++) {
            $toMails[] = $i . 'hello@example.com';
        }

        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            $toMails
        );

        MailManager::sendViaMailgun($manager, $message);
    }
}
