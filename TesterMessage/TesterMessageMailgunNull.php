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

/**
 * Class TesterMessageMailgunNull
 * @package BespokeSupport\MailWrapper\TesterMessage
 */
class TesterMessageMailgunNull extends MailgunMessage
{
    /**
     * @return bool
     */
    public function finalize()
    {
        return true;
    }
}
