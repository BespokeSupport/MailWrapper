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

namespace BespokeSupport\MailWrapper\TesterMessage;

use BespokeSupport\MailWrapper\Tests\MailWrapperTestBootstrap;

/**
 * Class TesterMessageZend
 * @package BespokeSupport\MailWrapper\TesterMessage
 */
class TesterMessagePhpMailer
{
    /**
     * @return \PHPMailer
     */
    public static function getNoValidNoCc()
    {
        $message = new \PHPMailer();

        $message->From = MailWrapperTestBootstrap::$from;
        $message->addAddress(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addAddress(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->Subject = MailWrapperTestBootstrap::$subject;
        $message->Body = MailWrapperTestBootstrap::$contentText;
        $message->AltBody = MailWrapperTestBootstrap::$contentHtml;

        return $message;
    }

    /**
     * @return \PHPMailer
     */
    public static function getNotValidNoBody()
    {
        $message = new \PHPMailer();

        $message->From = MailWrapperTestBootstrap::$from;
        $message->addAddress(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addAddress(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->Subject = MailWrapperTestBootstrap::$subject;

        return $message;
    }

    /**
     * @return \PHPMailer
     */
    public static function getNotValidNoFrom()
    {
        $message = new \PHPMailer();

        $message->addAddress(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addAddress(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->Subject = MailWrapperTestBootstrap::$subject;
        $message->Body = MailWrapperTestBootstrap::$contentText;
        $message->AltBody = MailWrapperTestBootstrap::$contentHtml;

        return $message;
    }

    /**
     * @return \PHPMailer
     */
    public static function getNotValidNoSubject()
    {
        $message = new \PHPMailer();

        $message->From = MailWrapperTestBootstrap::$from;
        $message->addAddress(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addAddress(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->Body = MailWrapperTestBootstrap::$contentText;
        $message->AltBody = MailWrapperTestBootstrap::$contentHtml;

        return $message;
    }

    /**
     * @return \PHPMailer
     */
    public static function getNotValidNoTo()
    {
        $message = new \PHPMailer();

        $message->From = MailWrapperTestBootstrap::$from;
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->Subject = MailWrapperTestBootstrap::$subject;
        $message->Body = MailWrapperTestBootstrap::$contentText;
        $message->AltBody = MailWrapperTestBootstrap::$contentHtml;

        return $message;
    }

    /**
     * @return \PHPMailer
     */
    public static function getValid()
    {
        $message = new \PHPMailer();

        $message->From = MailWrapperTestBootstrap::$from;
        $message->addAddress(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addAddress(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->Subject = MailWrapperTestBootstrap::$subject;
        $message->Body = MailWrapperTestBootstrap::$contentText;
        $message->AltBody = MailWrapperTestBootstrap::$contentHtml;

        return $message;
    }
}
