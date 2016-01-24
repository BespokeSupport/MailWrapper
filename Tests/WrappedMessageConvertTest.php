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

use BespokeSupport\MailWrapper\MailWrappedMessage;
use BespokeSupport\MailWrapper\MessageTransformer;

/**
 * Class WrappedMessageConvertTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class WrappedMessageConvertTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function testConvert()
    {
        $message = new MailWrappedMessage();
        $newMessage = MessageTransformer::convert($message, 'wrappedMessage');
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailWrappedMessage', $newMessage);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testConvertNull()
    {
        $message = new MailWrappedMessage();
        MessageTransformer::convert($message, null);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testConvertNullNull()
    {
        MessageTransformer::convert(null, null);
    }

    /**
     *
     */
    public function testReturn()
    {
        $message = new MailWrappedMessage();
        $newMessage = MessageTransformer::getWrappedMessage($message);
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailWrappedMessage', $newMessage);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testReturnNull()
    {
        MessageTransformer::getWrappedMessage(null);
    }

    /**
     *
     */
    public function testTransformToWrappedMessage()
    {
        $message = new MailWrappedMessage();
        $newMessage = MessageTransformer::getWrappedMessage($message);
        $this->assertInstanceOf('BespokeSupport\MailWrapper\MailWrappedMessage', $newMessage);
    }
}
