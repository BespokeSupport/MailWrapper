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
class MessageTest extends \PHPUnit_Framework_TestCase
{
    public function testNoTo()
    {
        $fromEmail = 'hello@example.com';
        $toEmails = null;
        $message = MailManager::getMailMessage($fromEmail, 'test Subject', 'testContent', $toEmails);
        $this->assertFalse($message);
    }

    public function testString()
    {
        $fromEmail = 'hello@example.com';
        $toEmails = 'hello2@example.com';
        $message = MailManager::getMailMessage($fromEmail, 'test Subject', 'testContent', $toEmails);
        $this->assertInstanceOf('\Swift_Message', $message);
        $this->assertCount(1, $message->getTo());
    }

    public function testMultiple()
    {
        $fromEmail = 'hello@example.com';
        $toEmail1 = 'hello1@example.com';
        $toEmail2 = 'hello2@example.com';
        $message = MailManager::getMailMessage($fromEmail, 'test Subject', 'testContent', $toEmail1, $toEmail2);
        $this->assertInstanceOf('\Swift_Message', $message);
        $this->assertCount(2, $message->getTo());
    }
}
