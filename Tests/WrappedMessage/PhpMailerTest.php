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
use BespokeSupport\MailWrapper\MessageTransformerPhpMailer;
use BespokeSupport\MailWrapper\TesterMessage\TesterMessagePhpMailer;
use BespokeSupport\MailWrapper\TesterMessage\TesterWrappedMessage;
use BespokeSupport\MailWrapper\Tests\MailWrapperTestBootstrap;

/**
 * Class PhpMailerTest
 * @package BespokeSupport\MailWrapper\Tests\WrappedMessage
 */
class PhpMailerTest extends MailWrapperTestBootstrap
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
     *
     */
    public function testValidFrom()
    {
        $message = TesterMessagePhpMailer::getValid();
        $this->assertTrue(MessageTransformerPhpMailer::isValid($message));
        $wrappedMessage = MessageTransformerPhpMailer::toWrappedMessage($message);
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
        $this->assertFalse(MessageTransformerPhpMailer::isValid(null));
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNull()
    {
        MessageTransformerPhpMailer::toWrappedMessage(null);
    }

    /**
     *
     */
    public function testTransformToWrappedMessage()
    {
        $message = TesterMessagePhpMailer::getValid();
        $newMessage = MessageTransformer::getWrappedMessage($message);
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailWrappedMessage', $newMessage);
    }

    /**
     *
     */
    public function testConvert()
    {
        $message = TesterMessagePhpMailer::getValid();
        $newMessage = MessageTransformer::convert($message, 'phpmailer');
        $this->assertInstanceOf('PHPMailer', $newMessage);
    }

    /**
     *
     */
    public function testValidTo()
    {
        $wrappedMessage = TesterWrappedMessage::getValid();
        $message = MessageTransformerPhpMailer::fromWrappedMessage($wrappedMessage);
        $this->assertInstanceOf('\PHPMailer', $message);
        $this->assertCount(2, $message->getToAddresses());
        $this->assertCount(2, $message->getCcAddresses());
        $this->assertCount(2, $message->getBccAddresses());
        $this->assertGreaterThan(0, strlen($message->Subject));
        $this->assertGreaterThan(0, strlen($message->Body));
        $this->assertGreaterThan(0, strlen($message->AltBody));
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNullFromWrappedMessage()
    {
        MessageTransformerPhpMailer::fromWrappedMessage(null);
    }
}
