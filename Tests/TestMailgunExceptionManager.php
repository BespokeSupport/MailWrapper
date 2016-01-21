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
 * Class TestMailgunExceptionManager
 * @package BespokeSupport\MailWrapper\Tests
 */
class TestMailgunExceptionManager extends MailgunManager
{
    /**
     * @return TestMailgunExceptionBatch
     */
    public function batch()
    {
        return new TestMailgunExceptionBatch($this->restClient, $this->domain, false);
    }
}
