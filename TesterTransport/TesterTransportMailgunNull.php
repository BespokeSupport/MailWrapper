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
use BespokeSupport\MailWrapper\TesterMessage\TesterMessageMailgunNull;

/**
 * Class TesterTransportMailgunNull
 * @package BespokeSupport\MailWrapper\TesterTransport
 */
class TesterTransportMailgunNull extends MailgunManager
{
    /**
     * @return TesterMessageMailgunNull
     */
    public function batch()
    {
        return new TesterMessageMailgunNull($this->restClient, $this->domain, false);
    }
}
