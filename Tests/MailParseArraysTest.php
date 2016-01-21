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
 * Class MailParseArraysTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class MailParseArraysTest extends \PHPUnit_Framework_TestCase
{
    public function testOneArray()
    {
        $email = ['hello@example.com'];
        $this->assertCount(1, MailAddressManager::combineRecipients($email));
    }

    public function testTwoArray()
    {
        $email = [
            'hello1@example.com',
            'hello2@example.com',
        ];
        $this->assertCount(2, MailAddressManager::combineRecipients($email));
    }

    public function testTwoIdenticalArray()
    {
        $email = [
            'hello1@example.com',
            'hello1@example.com',
        ];
        $this->assertCount(1, MailAddressManager::combineRecipients($email));
    }

    public function testTwoArraysArray()
    {
        $email1 = [
            'hello1@example.com',
            'hello2@example.com',
        ];
        $email2 = [
            'hello3@example.com',
            'hello4@example.com',
        ];
        $this->assertCount(4, MailAddressManager::combineRecipients($email1, $email2));
    }

    public function testTwoArraysOneArray()
    {
        $email1 = [
            'hello1@example.com',
            'hello1@example.com',
        ];
        $email2 = [
            'hello1@example.com',
            'hello1@example.com',
        ];
        $this->assertCount(1, MailAddressManager::combineRecipients($email1, $email2));
    }

    public function testTwoArraysTwoArray()
    {
        $email1 = [
            'hello1@example.com',
            'hello2@example.com',
        ];
        $email2 = [
            'hello1@example.com',
            'hello2@example.com',
        ];
        $this->assertCount(2, MailAddressManager::combineRecipients($email1, $email2));
    }

    public function testTwoMultiLevelArraysTwoArray()
    {
        $email1 = [
            [
                'hello1@example.com',
                'hello2@example.com',
            ],
            'hello3@example.com',
        ];
        $email2 = [
            'hello4@example.com',
            [
                'hello5@example.com',
                'hello6@example.com',
            ]
        ];
        $this->assertCount(6, MailAddressManager::combineRecipients($email1, $email2));
    }
}
