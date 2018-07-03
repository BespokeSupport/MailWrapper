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

use BespokeSupport\MailWrapper\MailWrappedMessage;
use BespokeSupport\MailWrapper\MessageTransformer;
use BespokeSupport\MailWrapper\MessageTransformerPostmark;
use BespokeSupport\MailWrapper\TesterMessage\TesterMessagePostmark;
use BespokeSupport\MailWrapper\TesterMessage\TesterWrappedMessage;
use BespokeSupport\MailWrapper\Tests\MailWrapperTestBootstrap;
use BespokeSupport\PostmarkInbound\PostmarkInbound;

/**
 * Class PostmarkTest
 * @package BespokeSupport\MailWrapper\Tests\WrappedMessage
 */
class PostmarkTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function setUp()
    {
        if (!class_exists('BespokeSupport\PostmarkInbound\PostmarkInbound')) {
            $this->markTestSkipped('BespokeSupport\PostmarkInbound\PostmarkInbound not installed');
        }
    }

    public function testFrom()
    {
        $message = TesterMessagePostmark::getValid();
        $newMessage = MessageTransformer::convert($message);
        $this->assertInstanceOf(MailWrappedMessage::class, $newMessage);
    }

    public function testValid()
    {
        $message = TesterMessagePostmark::getValid();
        $this->assertTrue(MessageTransformerPostmark::isValid($message));
    }

    public function testNotValid()
    {
        $this->assertFalse(MessageTransformerPostmark::isValid(null));
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNullFromWrappedMessage()
    {
        MessageTransformerPostmark::fromWrappedMessage(null);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNull()
    {
        MessageTransformerPostmark::toWrappedMessage(null);
    }

    public function testTo()
    {
        $message = TesterWrappedMessage::getValid();
        $newMessage = MessageTransformer::convert($message, 'postmark');
        $this->assertInstanceOf(PostmarkInbound::class, $newMessage);
    }
}
