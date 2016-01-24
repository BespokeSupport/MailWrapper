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

use BespokeSupport\MailWrapper\MailWrappedMessage;
use BespokeSupport\MailWrapper\Tests\MailWrapperTestBootstrap;

/**
 * Class TesterWrappedMessage
 * @package BespokeSupport\MailWrapper\TesterMessage
 */
class TesterWrappedMessage
{
    /**
     * @return MailWrappedMessage
     */
    public static function getNoValidBody()
    {
        $message = new MailWrappedMessage();

        $message->setFrom(MailWrapperTestBootstrap::$from);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->setReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);

        return $message;
    }

    /**
     * @return MailWrappedMessage
     */
    public static function getNotValidNoCc()
    {
        $message = new MailWrappedMessage();

        $message->setFrom(MailWrapperTestBootstrap::$from);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->setReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setContentText(MailWrapperTestBootstrap::$contentText);
        $message->setContentHtml(MailWrapperTestBootstrap::$contentHtml);

        return $message;
    }

    /**
     * @return \PHPMailer
     */
    public static function getNotValidNoFrom()
    {
        $message = new MailWrappedMessage();

        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->setReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setContentText(MailWrapperTestBootstrap::$contentText);
        $message->setContentHtml(MailWrapperTestBootstrap::$contentHtml);

        return $message;
    }

    /**
     * @return MailWrappedMessage
     */
    public static function getNotValidNoSubject()
    {
        $message = new MailWrappedMessage();

        $message->setFrom(MailWrapperTestBootstrap::$from);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->setReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setContentText(MailWrapperTestBootstrap::$contentText);
        $message->setContentHtml(MailWrapperTestBootstrap::$contentHtml);

        return $message;
    }

    /**
     * @return MailWrappedMessage
     */
    public static function getNotValidNoTo()
    {
        $message = new MailWrappedMessage();

        $message->setFrom(MailWrapperTestBootstrap::$from);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->setReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setContentText(MailWrapperTestBootstrap::$contentText);
        $message->setContentHtml(MailWrapperTestBootstrap::$contentHtml);

        return $message;
    }

    /**
     * @return MailWrappedMessage
     */
    public static function getValid()
    {
        $message = new MailWrappedMessage();

        $message->setFrom(MailWrapperTestBootstrap::$from);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->setReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setContentText(MailWrapperTestBootstrap::$contentText);
        $message->setContentHtml(MailWrapperTestBootstrap::$contentHtml);

        return $message;
    }
}
