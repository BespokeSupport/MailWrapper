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
 * Class TestEntityString
 * @package BespokeSupport\MailWrapper\Tests
 */
class TestEntityString
{
    /**
     * @var string
     */
    public $myEmail;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->myEmail;
    }
}
