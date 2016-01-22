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

namespace BespokeSupport\MailWrapper\TesterMessage;

use BespokeSupport\MailWrapper\MailgunMessage;
use Mailgun\Connection\Exceptions\InvalidCredentials;

/**
 * Class TesterMessageMailgunException
 * @package BespokeSupport\MailWrapper\TesterMessage
 */
class TesterMessageMailgunException extends MailgunMessage
{
    /**
     * @throws InvalidCredentials
     */
    public function finalize()
    {
        throw new InvalidCredentials;
    }
}
