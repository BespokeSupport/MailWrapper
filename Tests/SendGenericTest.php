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

/**
 * Class SendGenericTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class SendGenericTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testException()
    {
        $transport = null;
        MailManager::sendTo($transport, 'hello@example.com', 'subject', 'content', null);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testExceptionNulls()
    {
        MailManager::sendTo(null, null, null, null, null);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testExceptionNullValidEmail()
    {
        MailManager::sendTo(null, null, null, null, 'hello@example.com');
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testSendExceptionNulls()
    {
        MailManager::sendExceptionTo(null, null, null, new \Exception('test'), null);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testSendExceptionNullValidEmail()
    {
        MailManager::sendExceptionTo(null, null, null, new \Exception('test'), 'hello@example.com');
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testSendNoTransport()
    {
        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );

        MailManager::send($message);
    }

    public function testSendMultiple()
    {
        $transport1 = new \Swift_NullTransport();
        $transport2 = new \Swift_NullTransport();
        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );

        MailManager::send($message, $transport1, $transport2);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSendException
     */
    public function testSendSingleFail()
    {
        $transport1 = new TestSwiftExceptionTransport();
        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );

        MailManager::send($message, $transport1);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testSendMultipleException()
    {
        $transport1 = null;
        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );

        MailManager::send($message, $transport1);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testSendViaFail()
    {
        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );

        MailManager::sendVia($message, null);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testSendExceptionMessage()
    {
        MailManager::send(null);
    }
}
