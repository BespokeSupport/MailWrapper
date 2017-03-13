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

use Postmark\PostmarkClient;

/**
 * Class PostmarkManager
 * @package BespokeSupport\MailWrapper
 */
class PostmarkManager extends PostmarkClient
{
    public $trackOpen = true;

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
