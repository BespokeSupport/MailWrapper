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

namespace BespokeSupport\MailWrapper\Tests\WrappedMessage;

use BespokeSupport\MailWrapper\MailgunManager;
use BespokeSupport\MailWrapper\MailWrappedMessage;
use BespokeSupport\MailWrapper\MessageTransformer;
use BespokeSupport\MailWrapper\MessageTransformerMailgun;
use BespokeSupport\MailWrapper\TesterMessage\TesterMessageMailgun;
use BespokeSupport\MailWrapper\TesterMessage\TesterWrappedMessage;
use BespokeSupport\MailWrapper\TesterTransport\TesterTransportMailgunNull;
use BespokeSupport\MailWrapper\Tests\MailWrapperTestBootstrap;

/**
 * Class MailgunTest
 * @package BespokeSupport\MailWrapper\Tests\WrappedMessage
 */
class MailgunTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function setUp()
    {
        if (!class_exists('Mailgun\Mailgun')) {
            $this->markTestSkipped('Mailgun not installed');
        }
    }

    /**
     *
     */
    public function testValidTo()
    {
        $transport = new TesterTransportMailgunNull('TEST', 'example.com');
        $wrappedMessage = TesterWrappedMessage::getValid();
        $message = MessageTransformerMailgun::fromWrappedMessage($wrappedMessage, $transport);
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailgunMessage', $message);
        $this->assertCount(2, $message->getMessage()['to']);
        $this->assertCount(2, $message->getMessage()['cc']);
        $this->assertCount(2, $message->getMessage()['bcc']);
        $this->assertGreaterThan(0, strlen($message->getMessage()['subject']));
        $this->assertGreaterThan(0, strlen($message->getMessage()['text']));
        $this->assertGreaterThan(0, strlen($message->getMessage()['html']));
        $this->assertEquals(2, $message->getRecipientCount('to'));
        $this->assertEquals(2, $message->getRecipientCount('cc'));
        $this->assertEquals(2, $message->getRecipientCount('bcc'));
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testInvalidRecipient()
    {
        $manager = MailgunManager::newInstance('TEST', 'example.com');
        $message = $manager->batch();
        $message->getRecipientCount(null);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testConstruct1()
    {
        MailgunManager::newInstance(null, 'TEST');
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNullFromWrappedMessage()
    {
        MessageTransformerMailgun::fromWrappedMessage(null);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testConstruct2()
    {
        MailgunManager::newInstance('TEST', null);
    }

    /**
     *
     */
    public function testValidFrom()
    {
        $message = TesterMessageMailgun::getValid();
        $this->assertTrue(MessageTransformerMailgun::isValid($message));
        $wrappedMessage = MessageTransformerMailgun::toWrappedMessage($message);
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailWrappedMessage', $wrappedMessage);
        $this->assertCount(2, $wrappedMessage->getToRecipients());
        $this->assertCount(2, $wrappedMessage->getCcRecipients());
        $this->assertCount(2, $wrappedMessage->getBccRecipients());
        $this->assertGreaterThan(0, strlen($wrappedMessage->getSubject()));
        $this->assertGreaterThan(0, strlen($wrappedMessage->getContentText()));
        $this->assertGreaterThan(0, strlen($wrappedMessage->getContentHtml()));
    }

    /**
     *
     */
    public function testNotValid()
    {
        $this->assertFalse(MessageTransformerMailgun::isValid(null));
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNull()
    {
        MessageTransformerMailgun::toWrappedMessage(null);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNullTransport()
    {
        $wrappedMessage = new MailWrappedMessage();
        MessageTransformerMailgun::fromWrappedMessage($wrappedMessage, null);
    }

    /**
     *
     */
    public function testTransformToWrappedMessage()
    {
        $message = TesterMessageMailgun::getValid();
        $newMessage = MessageTransformer::getWrappedMessage($message);
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailWrappedMessage', $newMessage);
    }

    /**
     *
     */
    public function testConvert()
    {
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        $message = TesterMessageMailgun::getValid();
        $newMessage = MessageTransformer::convert($message, 'mailgun', $transport);
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailgunMessage', $newMessage);
    }
}
