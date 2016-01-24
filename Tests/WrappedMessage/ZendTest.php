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
use BespokeSupport\MailWrapper\MessageTransformerZend;
use BespokeSupport\MailWrapper\TesterMessage\TesterMessageZend;
use BespokeSupport\MailWrapper\TesterMessage\TesterWrappedMessage;
use BespokeSupport\MailWrapper\Tests\MailWrapperTestBootstrap;

/**
 * Class ZendTest
 * @package BespokeSupport\MailWrapper\Tests\WrappedMessage
 */
class ZendTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function setUp()
    {
        if (!class_exists('Zend\Mail\Message')) {
            $this->markTestSkipped('Zend Mailer not installed');
        }
    }

    /**
     *
     */
    public function testValidFrom()
    {
        $message = TesterMessageZend::getValid();
        $this->assertTrue(MessageTransformerZend::isValid($message));
        $wrappedMessage = MessageTransformerZend::toWrappedMessage($message);
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
        $this->assertFalse(MessageTransformerZend::isValid(null));
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNull()
    {
        MessageTransformerZend::toWrappedMessage(null);
    }

    /**
     *
     */
    public function testTransformToWrappedMessage()
    {
        $message = TesterMessageZend::getValid();
        $newMessage = MessageTransformer::getWrappedMessage($message);
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailWrappedMessage', $newMessage);
    }

    /**
     *
     */
    public function testConvert()
    {
        $message = TesterMessageZend::getValid();
        $newMessage = MessageTransformer::convert($message, 'zend');
        $this->assertInstanceOf('Zend\Mail\Message', $newMessage);
    }

    /**
     *
     */
    public function testValidTo()
    {
        $wrappedMessage = TesterWrappedMessage::getValid();
        $message = MessageTransformerZend::fromWrappedMessage($wrappedMessage);
        $this->assertInstanceOf('Zend\Mail\Message', $message);
        $this->assertCount(2, $message->getTo());
        $this->assertCount(2, $message->getCc());
        $this->assertCount(2, $message->getBcc());
        $this->assertGreaterThan(0, strlen($message->getSubject()));
        $this->assertGreaterThan(0, strlen($message->getBody()));
    }
}
