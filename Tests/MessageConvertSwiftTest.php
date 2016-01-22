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
 * Class MessageConvertSwiftTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class MessageConvertSwiftTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function setUp()
    {
        if (!class_exists('Swift_Message')) {
            $this->markTestSkipped('Swift_Mailer / Swift_Message not installed');
        }
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNoConverterSwift()
    {
        MessageTransformer::convert('swift', null);
        $this->assertTrue(true);
    }

    /**
     *
     */
    public function testSwiftToMailgun()
    {
        $message = new \Swift_Message();
        $message->addTo('hello@example.com');
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        MessageTransformer::convert('mailgun', $message, $transport);
        $this->assertTrue(true);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     * No TO
     */
    public function testSwiftToMailgunExceptionTo()
    {
        $message = new \Swift_Message();
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        MessageTransformer::convert('mailgun', $message, $transport);
        $this->assertTrue(true);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     * No Transport
     */
    public function testSwiftToMailgunExceptionTransport()
    {
        $message = new \Swift_Message();
        $message->addTo('hello@example.com');
        MessageTransformer::convert('mailgun', $message, null);
        $this->assertTrue(true);
    }
}
