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

namespace BespokeSupport\MailWrapper;

/**
 * Class PostmarkAddress
 * @package BespokeSupport\MailWrapper
 */
class PostmarkAddress extends \stdClass
{
    public $Name;
    public $Email;
    public $MailboxHash;
}
