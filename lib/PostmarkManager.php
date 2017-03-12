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
 * Class PostmarkManager
 * @package BespokeSupport\MailWrapper
 */
class PostmarkManager
{
    /**
     * @return PostmarkInboundMessage
     */
    public static function getInboundData()
    {
        $data = new PostmarkInboundMessage();

        $data->FromFull = self::getAddress();

        return $data;
    }

    /**
     * @param null $email
     * @return PostmarkAddress
     */
    public static function getAddress($email = null)
    {
        $full = new PostmarkAddress();

        $full->Email = $email;

        return $full;
    }
}
