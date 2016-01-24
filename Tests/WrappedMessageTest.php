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

use BespokeSupport\MailWrapper\MailManager;
use BespokeSupport\MailWrapper\MailWrappedMessage;
use BespokeSupport\MailWrapper\TesterMessage\TesterWrappedMessage;

/**
 * Class WrappedMessageTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class WrappedMessageTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function testInstance()
    {
        $newMessage = MailWrappedMessage::newInstance();
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailWrappedMessage', $newMessage);
        $this->assertNull($newMessage->getWrappedMessage());
        $this->assertNull($newMessage->getMessage());
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testInstanceFail()
    {
        (MailWrappedMessage::newInstance(true));
    }
    /**
     *
     */
    public function testInstanceWrapped()
    {
        $wrappedMessage = TesterWrappedMessage::getValid();
        $newMessage = MailWrappedMessage::newInstance($wrappedMessage);
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailWrappedMessage', $newMessage);
        $this->assertNull($newMessage->getWrappedMessage());
        $this->assertNull($newMessage->getMessage());
        $this->assertCount(2, $wrappedMessage->getToRecipients());
        $this->assertCount(2, $wrappedMessage->getCcRecipients());
        $this->assertCount(2, $wrappedMessage->getBccRecipients());
    }

    /**
     *
     */
    public function testNoTo()
    {
        $fromEmail = 'hello@example.com';
        $toEmails = null;
        $message = MailManager::getMailMessage($fromEmail, 'test Subject', 'testContent', $toEmails);
        $this->assertFalse($message);
    }

    /**
     *
     */
    public function testWrappedBcc()
    {
        $wrappedMessage = new MailWrappedMessage();
        $this->assertCount(0, $wrappedMessage->getBccRecipients());
        $wrappedMessage->addBccRecipient(false);
        $this->assertCount(0, $wrappedMessage->getBccRecipients());
        $wrappedMessage->addBccRecipient(null);
        $this->assertCount(0, $wrappedMessage->getBccRecipients());
        $wrappedMessage->addBccRecipient(true);
        $this->assertCount(0, $wrappedMessage->getBccRecipients());
        $wrappedMessage->addBccRecipient(MailWrapperTestBootstrap::$alternate);
        $this->assertCount(1, $wrappedMessage->getBccRecipients());
        $wrappedMessage->addBccRecipient(MailWrapperTestBootstrap::$alternate);
        $this->assertCount(1, $wrappedMessage->getBccRecipients());
    }

    /**
     *
     */
    public function testWrappedCc()
    {
        $wrappedMessage = new MailWrappedMessage();
        $this->assertCount(0, $wrappedMessage->getCcRecipients());
        $wrappedMessage->addCcRecipient(false);
        $this->assertCount(0, $wrappedMessage->getCcRecipients());
        $wrappedMessage->addCcRecipient(null);
        $this->assertCount(0, $wrappedMessage->getCcRecipients());
        $wrappedMessage->addCcRecipient(true);
        $this->assertCount(0, $wrappedMessage->getCcRecipients());
        $wrappedMessage->addCcRecipient(MailWrapperTestBootstrap::$alternate);
        $this->assertCount(1, $wrappedMessage->getCcRecipients());
        $wrappedMessage->addCcRecipient(MailWrapperTestBootstrap::$alternate);
        $this->assertCount(1, $wrappedMessage->getCcRecipients());
    }

    /**
     *
     */
    public function testWrappedFrom()
    {
        $wrappedMessage = new MailWrappedMessage();
        $this->assertNull($wrappedMessage->getFrom());
        $wrappedMessage->setFrom(MailWrapperTestBootstrap::$alternate);
        $this->assertNotNull($wrappedMessage->getFrom());
    }

    /**
     *
     */
    public function testWrappedMessage()
    {
        if (!class_exists('Swift_Message')) {
            $this->markTestSkipped('Swift_Message not installed');
        }

        $wrappedMessage = new MailWrappedMessage();
        $this->assertNull($wrappedMessage->getMessage());
        $wrappedMessage = new MailWrappedMessage((new \Swift_Message()));
        $this->assertNotNull($wrappedMessage->getWrappedMessage());
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testWrappedMessageFail()
    {
        (new MailWrappedMessage(true));
    }

    /**
     *
     */
    public function testWrappedReplyTo()
    {
        $wrappedMessage = new MailWrappedMessage();
        $this->assertNull($wrappedMessage->getReplyTo());
        $wrappedMessage->setReplyTo(MailWrapperTestBootstrap::$alternate);
        $this->assertNotNull($wrappedMessage->getReplyTo());
    }

    /**
     *
     */
    public function testWrappedTo()
    {
        $wrappedMessage = new MailWrappedMessage();
        $this->assertCount(0, $wrappedMessage->getToRecipients());
        $wrappedMessage->addToRecipient(false);
        $this->assertCount(0, $wrappedMessage->getToRecipients());
        $wrappedMessage->addToRecipient(null);
        $this->assertCount(0, $wrappedMessage->getToRecipients());
        $wrappedMessage->addToRecipient(true);
        $this->assertCount(0, $wrappedMessage->getToRecipients());
        $wrappedMessage->addToRecipient(MailWrapperTestBootstrap::$alternate);
        $this->assertCount(1, $wrappedMessage->getToRecipients());
        $wrappedMessage->addToRecipient(MailWrapperTestBootstrap::$alternate);
        $this->assertCount(1, $wrappedMessage->getToRecipients());
    }
}
