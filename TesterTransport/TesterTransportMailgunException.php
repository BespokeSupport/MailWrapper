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

use BespokeSupport\MailWrapper\MailgunManager;
use BespokeSupport\MailWrapper\TesterMessage\TesterMessageMailgunException;

/**
 * Class TesterTransportMailgunException
 * @package BespokeSupport\MailWrapper\TesterTransport
 */
class TesterTransportMailgunException extends MailgunManager
{
    /**
     * @return TesterMessageMailgunException
     */
    public function batch()
    {
        return new TesterMessageMailgunException($this->restClient, $this->domain, false);
    }
}
