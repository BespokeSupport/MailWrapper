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

namespace BespokeSupport\MailWrapper\TesterEntity;

/**
 * Class TesterEmailEntity
 * @package BespokeSupport\MailWrapper\TesterEntity
 */
class TesterEmailEntity
{
    /**
     * @var string
     */
    public $myEmail;
    /**
     * @var string
     */
    protected $email;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->myEmail;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
