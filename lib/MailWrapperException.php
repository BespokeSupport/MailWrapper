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
 * Class MailWrapperException
 * @package BespokeSupport\MailWrapper
 */
class MailWrapperException extends \Exception
{
    /**
     * @return array
     */
    public function __sleep()
    {
        return [
            'message',
            'code',
            'file',
            'line',
        ];
    }
}
