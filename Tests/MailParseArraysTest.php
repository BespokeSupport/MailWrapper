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
class MailParseArraysTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function testOneArray()
    {
        $email = [self::$from];

        $response = MailAddressManager::combineRecipients($email);
        $this->assertCount(1, $response);
        $this->assertEquals(self::$from, $response[0]);
    }

    /**
     *
     */
    public function testTwoArray()
    {
        $email = self::$toAddresses;

        $response = MailAddressManager::combineRecipients($email);

        $this->assertCount(2, $response);
        $this->assertEquals(self::$toAddresses[0], $response[0]);
    }

    /**
     *
     */
    public function testTwoArraysArray()
    {
        $response = MailAddressManager::combineRecipients(self::$toAddresses, self::$ccAddresses);

        $this->assertCount(4, $response);
        $this->assertEquals(self::$toAddresses[0], $response[0]);
        $this->assertEquals(self::$toAddresses[1], $response[1]);
        $this->assertEquals(self::$ccAddresses[0], $response[2]);
        $this->assertEquals(self::$ccAddresses[1], $response[3]);
    }

    /**
     *
     */
    public function testTwoArraysOneArray()
    {
        $response = MailAddressManager::combineRecipients([self::$toAddresses[0]], [self::$toAddresses[0]]);

        $this->assertCount(1, $response);
        $this->assertEquals(self::$toAddresses[0], $response[0]);
    }

    /**
     *
     */
    public function testTwoArraysTwoArray()
    {
        $response = MailAddressManager::combineRecipients(self::$toAddresses, self::$toAddresses);

        $this->assertCount(2, $response);
        $this->assertEquals(self::$toAddresses[0], $response[0]);
        $this->assertEquals(self::$toAddresses[1], $response[1]);
    }

    /**
     *
     */
    public function testTwoIdenticalArray()
    {
        $email = self::getDuplicatedAddress('to');

        $response = MailAddressManager::combineRecipients($email);

        $this->assertCount(2, $response);
        $this->assertEquals(self::$toAddresses[0], $response[0]);
        $this->assertEquals(self::$toAddresses[1], $response[1]);
    }

    /**
     *
     */
    public function testTwoMultiLevelArraysTwoArray()
    {
        $email1 = [
            self::$toAddresses,
            self::$from,
        ];
        $email2 = [
            self::$bccAddresses,
            self::$ccAddresses,
        ];

        $response = MailAddressManager::combineRecipients($email1, $email2);

        $this->assertCount(7, $response);
    }
}
