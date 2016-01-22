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
 * Class MessageTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class MessageInstantiateSwiftTest extends MailWrapperTestBootstrap
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
     *
     */
    public function testMultiple()
    {
        $fromEmail = 'hello@example.com';
        $toEmail1 = 'hello1@example.com';
        $toEmail2 = 'hello2@example.com';
        $message = MailManager::getMailMessage($fromEmail, 'test Subject', 'testContent', $toEmail1, $toEmail2);
        $this->assertInstanceOf('\Swift_Message', $message);
        $this->assertCount(2, $message->getTo());
    }

    /**
     *
     */
    public function testString()
    {
        $fromEmail = 'hello@example.com';
        $toEmails = 'hello2@example.com';
        $message = MailManager::getMailMessage($fromEmail, 'test Subject', 'testContent', $toEmails);
        $this->assertInstanceOf('\Swift_Message', $message);
        $this->assertCount(1, $message->getTo());
    }
}
