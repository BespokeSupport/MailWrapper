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
 * Interface MessageTransformerInterface
 * @package BespokeSupport\MailWrapper
 */
interface MessageTransformerInterface
{
    /**
     * @param MailWrappedMessage $wrappedMessage
     * @param null $transport
     */
    public static function fromWrappedMessage(MailWrappedMessage $wrappedMessage = null, $transport = null);

    /**
     * @param $message
     * @return bool
     */
    public static function isValid($message);

    /**
     * @param $message
     * @return MailWrappedMessage
     */
    public static function toWrappedMessage($message);
}
