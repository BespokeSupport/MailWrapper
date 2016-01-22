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
class MessageTest extends MailWrapperTestBootstrap
{
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
}
