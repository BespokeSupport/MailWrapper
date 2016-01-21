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
 * Class TestEntity
 * @package BespokeSupport\MailWrapper\Tests
 */
class TestEntity
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    public $myEmail;

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
