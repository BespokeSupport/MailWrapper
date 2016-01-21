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

use BespokeSupport\MailWrapper\MailgunManager;

/**
 * Class TestMailgunNullManager
 * @package BespokeSupport\MailWrapper\Tests
 */
class TestMailgunNullManager extends MailgunManager
{
    /**
     * @return TestMailgunNullBatch
     */
    public function batch()
    {
        return new TestMailgunNullBatch($this->restClient, $this->domain, false);
    }
}
