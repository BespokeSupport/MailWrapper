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
 * Class MailAddressManager
 * @package BespokeSupport\MailWrapper
 */
class MailAddressManager
{
    /**
     * @return array
     */
    public static function combineRecipients()
    {
        $args = func_get_args();
        $recipientArray = [];
        foreach ($args as $entity) {
            switch (true) {
                case (is_array($entity)):
                    foreach ($entity as $item) {
                        switch (true) {
                            case (is_array($item)):
                                $newItems = static::combineRecipients($item);
                                $recipientArray = array_merge($recipientArray, $newItems);
                                break;
                            default:
                                $email = static::extractEmailString($item);
                                if ($email) {
                                    $recipientArray[] = $email;
                                }
                        }
                    }
                    break;

                default:
                    $email = static::extractEmailString($entity);
                    if ($email) {
                        $recipientArray[] = $email;
                    }
                    break;
            }
        }

        $recipientArray = array_unique($recipientArray);

        return $recipientArray;
    }

    /**
     * @param $email
     * @return bool|string
     */
    public static function extractEmailFromClass($email)
    {
        $reflection = new \ReflectionObject($email);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            if ($property->name == 'email') {
                if ($email->email) {
                    return filter_var($email->email, FILTER_VALIDATE_EMAIL);
                }
                break;
            }
        }

        return false;
    }

    /**
     * @param $email object|string
     * @return bool|string
     */
    public static function extractEmailString($email)
    {
        if (!is_string($email) && !is_object($email)) {
            return false;
        }

        if (is_string($email)) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        if (is_object($email)) {
            /**
             * @var $email object
             */
            if (method_exists($email, 'getEmail')) {
                $emailString = $email->getEmail();
                if ($emailString) {
                    return filter_var($emailString, FILTER_VALIDATE_EMAIL);
                }
            }

            $emailString = static::extractEmailFromClass($email);
            if (is_string($emailString)) {
                return $emailString;
            }
        }

        try {
            $string = (string)$email;
        } catch (\Exception $e) {
            return false;
        }

        return filter_var($string, FILTER_VALIDATE_EMAIL);
    }
}
