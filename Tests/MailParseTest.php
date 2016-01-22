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
use BespokeSupport\MailWrapper\TesterEntity\TesterEmailEntity;
use BespokeSupport\MailWrapper\TesterEntity\TesterEmailEntityString;

/**
 * Class MailParseTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class MailParseTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function testString()
    {
        $email = self::$to[0];
        $this->assertCount(1, MailAddressManager::combineRecipients($email));
    }

    /**
     *
     */
    public function testBoolTrue()
    {
        $email = true;
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }

    /**
     *
     */
    public function testBoolFalse()
    {
        $email = false;
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }

    /**
     *
     */
    public function testNull()
    {
        $email = null;
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }

    /**
     *
     */
    public function testObject()
    {
        $email = new \stdClass();
        $email->email = 'hello1@example.com';
        $this->assertCount(1, MailAddressManager::combineRecipients($email));
    }

    /**
     *
     */
    public function testObjectNull()
    {
        $email = new \stdClass();
        $email->email = null;
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }

    /**
     *
     */
    public function testClass()
    {
        $emailString = self::$to[0];

        $email = new TesterEmailEntity();
        $email->setEmail($emailString);

        $result = MailAddressManager::combineRecipients($email);
        $this->assertCount(1, $result);
        $this->assertEquals($emailString, $result[0]);
    }

    /**
     *
     */
    public function testClassNull()
    {
        $email = new TesterEmailEntity();
        $email->setEmail(null);
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }

    /**
     *
     */
    public function testClassStringZero()
    {
        $email = new TesterEmailEntityString();
        $this->assertCount(0, MailAddressManager::combineRecipients($email));
    }

    /**
     *
     */
    public function testClassString()
    {
        $emailString = self::$to[0];

        $email = new TesterEmailEntityString();
        $email->myEmail = $emailString;

        $result = MailAddressManager::combineRecipients($email);
        $this->assertCount(1, $result);
        $this->assertEquals($emailString, $result[0]);
    }
}
