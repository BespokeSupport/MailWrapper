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
use BespokeSupport\MailWrapper\TesterTransport\TesterTransportSwiftException;

/**
 * Class SwiftMailTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class SwiftMailTest extends MailWrapperTestBootstrap
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
    public function testExceptionMessage()
    {
        $transport = new \Swift_NullTransport();
        $message = null;
        MailManager::sendViaSwiftMailer($transport, $message);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testExceptionTransport()
    {
        $transport = null;
        MailManager::sendViaSwiftMailer($transport);
    }

    /**
     *
     */
    public function testSend()
    {
        $transport = new \Swift_NullTransport();
        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );
        MailManager::sendViaSwiftMailer($transport, $message);
    }

    /**
     *
     */
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
        $transport1 = new TesterTransportSwiftException();
        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );

        MailManager::send($message, $transport1);
    }

    /**
     *
     */
    public function testSendVia()
    {
        $transport = new \Swift_NullTransport();
        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );
        MailManager::sendVia($transport, $message);
    }

    /**
     *
     */
    public function testSendViaException()
    {
        $transport = new \Swift_NullTransport();
        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );
        MailManager::sendVia($transport, $message);
    }

    /**
     *
     */
    public function testSendViaWrapped()
    {
        $transport = new \Swift_NullTransport();
        $mailer = new \Swift_Mailer($transport);
        $message = MailManager::getMailMessage(
            'hello@example.com',
            'hello@example.com',
            'hello@example.com',
            'hello@example.com'
        );
        MailManager::sendVia($mailer, $message);
    }
}
