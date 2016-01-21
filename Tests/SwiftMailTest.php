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
 * Class SwiftMailTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class SwiftMailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testExceptionTransport()
    {
        $transport = null;
        MailManager::sendViaSwiftMailer($transport);
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
