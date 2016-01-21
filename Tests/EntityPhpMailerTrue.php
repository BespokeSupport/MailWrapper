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
 * Class EntityPhpMailerNull
 * @package BespokeSupport\MailWrapper\Tests
 */
class EntityPhpMailerTrue extends \PHPMailer
{
    /**
     * @return bool
     */
    public function send()
    {
        return $this->preSend();
    }

    /**
     * @return bool
     */
    public function postSend()
    {
        return true;
    }
}
