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
     * @var array
     */
    protected static $bcc = [
        'bcc1@example.com',
        'bcc2@example.com',
    ];
    /**
     * @var array
     */
    protected static $cc = [
        'cc1@example.com',
        'cc2@example.com',
    ];
    /**
     * @var string
     */
    protected static $contentHtml = 'testContentHtml';
    /**
     * @var string
     */
    protected static $contentText = 'testContentText';
    /**
     * @var string
     */
    protected static $from = 'from@example.com';
    /**
     * @var string
     */
    protected static $subject = 'testSubject';
    /**
     * @var array
     */
    protected static $to = [
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

        return array_merge(
            self::$$key,
            self::$$key
        );
    }
}
