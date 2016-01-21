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

use BespokeSupport\MailWrapper\MailgunMessage;
use Mailgun\Connection\Exceptions\InvalidCredentials;

/**
 * Class TestMailgunExceptionBatch
 * @package BespokeSupport\MailWrapper\Tests
 */
class TestMailgunExceptionBatch extends MailgunMessage
{
    /**
     * @throws InvalidCredentials
     */
    public function finalize()
    {
        throw new InvalidCredentials;
    }
}
