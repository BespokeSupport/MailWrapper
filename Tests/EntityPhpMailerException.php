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
 * Class EntityPhpMailerException
 * @package BespokeSupport\MailWrapper\Tests
 */
class EntityPhpMailerException extends \PHPMailer
{
    /**
     * @throws \phpmailerException
     */
    public function send()
    {
        throw new \phpmailerException();
    }
    /**
     * @throws \phpmailerException
     */
    public function postSend()
    {
        throw new \phpmailerException();
    }
}
