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

namespace BespokeSupport\MailWrapper\TesterTransport;

/**
 * Class TesterTransportPhpMailerNull
 * @package BespokeSupport\MailWrapper\TesterTransport
 */
class TesterTransportPhpMailerNull extends \PHPMailer
{
    /**
     * @return bool
     */
    public function postSend()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function send()
    {
        return $this->preSend();
    }
}
