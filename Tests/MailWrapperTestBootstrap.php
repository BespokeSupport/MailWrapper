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

/**
 * Class MailWrapperTestBootstrap
 * @package BespokeSupport\MailWrapper\Tests
 */
class MailWrapperTestBootstrap extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    public static $alternate = 'alternate@example.com';
    /**
     * @var array
     */
    public static $bccAddresses = [
        'bcc1@example.com',
        'bcc2@example.com',
    ];
    /**
     * @var array
     */
    public static $ccAddresses = [
        'cc1@example.com',
        'cc2@example.com',
    ];
    /**
     * @var string
     */
    public static $contentHtml = 'testContentHtml';
    /**
     * @var string
     */
    public static $contentText = 'testContentText';
    /**
     * @var string
     */
    public static $from = 'from@example.com';
    /**
     * @var string
     */
    public static $invalid = 'INVALID';
    /**
     * @var string
     */
    public static $subject = 'testSubject';
    /**
     * @var array
     */
    public static $toAddresses = [
        'to1@example.com',
        'to2@example.com',
    ];

    /**
     * @param $key
     * @return array
     * @throws \Exception
     */
    public static function getDuplicatedAddress($key)
    {
        if (!in_array($key, ['to', 'cc', 'bcc'])) {
            throw new \Exception('Invalid Tester Address Key');
        }

        $theKey = $key . 'Addresses';

        return array_merge(
            self::$$theKey,
            self::$$theKey
        );
    }
}
