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
use Zend\Mail\Message;

/**
 * Class MessageConvertZendTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class MessageConvertZendTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function setUp()
    {
        if (!class_exists('Zend\Mail\Message')) {
            $this->markTestSkipped('Zend Mail (zf2) not installed');
        }
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testZendExceptionDestination()
    {
        $message = new Message();
        MessageTransformer::convert('ERR', $message);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     * No Transport
     */
    public function testZendToMailgunExceptionTransport()
    {
        $message = new Message();
        $message->setFrom('hello@example.com');
        MessageTransformer::convert('mailgun', $message);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     * No Transport
     */
    public function testZendToMailgunExceptionFrom()
    {
        $message = new Message();
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        MessageTransformer::convert('mailgun', $message, $transport);
    }

    /**
     *
     */
    public function testZendToMailgunTransport()
    {
        $message = new Message();
        $message->setFrom('hello@example.com');
        $transport = MailgunManager::newInstance('TEST', 'example.com');
        MessageTransformer::convert('mailgun', $message, $transport);
        $this->assertTrue(true);
    }

    /**
     *
     */
    public function testZendToSwift()
    {
        $message = new Message();
        MessageTransformer::convert('swift', $message);
        $this->assertTrue(true);
    }
}
