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

/**
 * Class TestMailgunNullBatch
 * @package BespokeSupport\MailWrapper\Tests
 */
class TestMailgunNullBatch extends MailgunMessage
{
    /**
     * @return bool
     */
    public function finalize()
    {
        return true;
    }
}
