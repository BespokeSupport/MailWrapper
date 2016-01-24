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

use BespokeSupport\MailWrapper\MessageTransformer;
use BespokeSupport\MailWrapper\MessageTransformerSwift;
use BespokeSupport\MailWrapper\TesterMessage\TesterMessageSwift;
use BespokeSupport\MailWrapper\TesterMessage\TesterWrappedMessage;
use BespokeSupport\MailWrapper\Tests\MailWrapperTestBootstrap;

/**
 * Class SwiftMailTest
 * @package BespokeSupport\MailWrapper\Tests\WrappedMessage
 */
class SwiftMailTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function setUp()
    {
        if (!class_exists('Swift_Mailer')) {
            $this->markTestSkipped('Swift_Mailer not installed');
        }
    }

    /**
     *
     */
    public function testValidFrom()
    {
        $message = TesterMessageSwift::getValid();
        $this->assertTrue(MessageTransformerSwift::isValid($message));
        $wrappedMessage = MessageTransformerSwift::toWrappedMessage($message);
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailWrappedMessage', $wrappedMessage);
        $this->assertCount(2, $wrappedMessage->getToRecipients());
        $this->assertCount(2, $wrappedMessage->getCcRecipients());
        $this->assertCount(2, $wrappedMessage->getBccRecipients());
        $this->assertGreaterThan(0, strlen($wrappedMessage->getSubject()));
        $this->assertGreaterThan(0, strlen($wrappedMessage->getContentText()));
        $this->assertEquals(0, strlen($wrappedMessage->getContentHtml()));
    }

    /**
     *
     */
    public function testNotValid()
    {
        $this->assertFalse(MessageTransformerSwift::isValid(null));
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNull()
    {
        MessageTransformerSwift::toWrappedMessage(null);
    }

    /**
     *
     */
    public function testTransformToWrappedMessage()
    {
        $message = TesterMessageSwift::getValid();
        $newMessage = MessageTransformer::getWrappedMessage($message);
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailWrappedMessage', $newMessage);
    }

    /**
     *
     */
    public function testConvert()
    {
        $message = TesterMessageSwift::getValid();
        $newMessage = MessageTransformer::convert($message, 'swift');
        $this->assertInstanceOf('\Swift_Message', $newMessage);
    }

    /**
     *
     */
    public function testValidTo()
    {
        $wrappedMessage = TesterWrappedMessage::getValid();
        $message = MessageTransformerSwift::fromWrappedMessage($wrappedMessage);
        $this->assertInstanceOf('\Swift_Message', $message);
        $this->assertCount(2, $message->getTo());
        $this->assertCount(2, $message->getCc());
        $this->assertCount(2, $message->getBcc());
        $this->assertGreaterThan(0, strlen($message->getSubject()));
        $this->assertGreaterThan(0, strlen($message->getBody()));
    }
}
