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
use Mailgun\Messages\MessageBuilder;

/**
 * Class TesterMessageMailgun
 * @package BespokeSupport\MailWrapper\TesterMessage
 */
class TesterMessageMailgun
{
    /**
     * @return MessageBuilder
     */
    public static function getNoValidBody()
    {
        $message = new MessageBuilder();

        $message->setFromAddress(MailWrapperTestBootstrap::$from);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->setReplyToAddress(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);

        return $message;
    }

    /**
     * @return MessageBuilder
     */
    public static function getNotValidNoCc()
    {
        $message = new MessageBuilder();

        $message->setFromAddress(MailWrapperTestBootstrap::$from);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->setReplyToAddress(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setTextBody(MailWrapperTestBootstrap::$contentText);
        $message->setHtmlBody(MailWrapperTestBootstrap::$contentHtml);

        return $message;
    }

    /**
     * @return \PHPMailer
     */
    public static function getNotValidNoFrom()
    {
        $message = new MessageBuilder();

        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->setReplyToAddress(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setTextBody(MailWrapperTestBootstrap::$contentText);
        $message->setHtmlBody(MailWrapperTestBootstrap::$contentHtml);

        return $message;
    }

    /**
     * @return MessageBuilder
     */
    public static function getNotValidNoSubject()
    {
        $message = new MessageBuilder();

        $message->setFromAddress(MailWrapperTestBootstrap::$from);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->setReplyToAddress(MailWrapperTestBootstrap::$alternate);
        $message->setTextBody(MailWrapperTestBootstrap::$contentText);
        $message->setHtmlBody(MailWrapperTestBootstrap::$contentHtml);

        return $message;
    }

    /**
     * @return MessageBuilder
     */
    public static function getNotValidNoTo()
    {
        $message = new MessageBuilder();

        $message->setFromAddress(MailWrapperTestBootstrap::$from);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->setReplyToAddress(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setTextBody(MailWrapperTestBootstrap::$contentText);
        $message->setHtmlBody(MailWrapperTestBootstrap::$contentHtml);

        return $message;
    }

    /**
     * @return MessageBuilder
     */
    public static function getValid()
    {
        $message = new MessageBuilder();

        $message->setFromAddress(MailWrapperTestBootstrap::$from);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addToRecipient(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCcRecipient(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBccRecipient(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->setReplyToAddress(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setTextBody(MailWrapperTestBootstrap::$contentText);
        $message->setHtmlBody(MailWrapperTestBootstrap::$contentHtml);

        return $message;
    }
}
