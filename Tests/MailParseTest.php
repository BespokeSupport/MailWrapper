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

use BespokeSupport\MailWrapper\MailAddressManager;

/**
 * Class MailParseTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class MailParseTest extends \PHPUnit_Framework_TestCase
{
    public function testString()
    {
        $email = 'hello@example.com';
        $this->assertCount(1, MailAddressManager::combineRecipients($email));
    }

    public function testBoolTrue()
    {
        $email = true;
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }

    public function testBoolFalse()
    {
        $email = false;
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }
    public function testNull()
    {
        $email = null;
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }

    public function testObject()
    {
        $email = new \stdClass();
        $email->email = 'hello1@example.com';
        $this->assertCount(1, MailAddressManager::combineRecipients($email));
    }

    public function testObjectNull()
    {
        $email = new \stdClass();
        $email->email = null;
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }

    public function testClass()
    {
        $email = new TestEntity();
        $email->setEmail('hello1@example.com');
        $this->assertCount(1, MailAddressManager::combineRecipients($email));
    }

    public function testClassNull()
    {
        $email = new TestEntity();
        $email->setEmail(null);
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }

    public function testClassStringZero()
    {
        $email = new TestEntityString();
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }

    public function testClassString()
    {
        $email = new TestEntityString();
        $email->myEmail = 'hello1@example.com';
        $this->assertCount(1, MailAddressManager::combineRecipients($email));
    }
}
