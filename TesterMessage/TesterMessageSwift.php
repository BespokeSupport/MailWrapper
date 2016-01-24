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
 * Class TesterMessageSwift
 * @package BespokeSupport\MailWrapper\TesterMessage
 */
class TesterMessageSwift
{
    /**
     * @return \Swift_Message
     */
    public static function getNoValidBody()
    {
        $message = new \Swift_Message();

        $message->setFrom(MailWrapperTestBootstrap::$from);
        $message->addTo(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addTo(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);

        return $message;
    }

    /**
     * @return \Swift_Message
     */
    public static function getNotValidNoCc()
    {
        $message = new \Swift_Message();

        $message->setFrom(MailWrapperTestBootstrap::$from);
        $message->addTo(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addTo(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setBody(MailWrapperTestBootstrap::$contentText);
        $message->addPart(MailWrapperTestBootstrap::$contentHtml, 'text/html');

        return $message;
    }

    /**
     * @return \PHPMailer
     */
    public static function getNotValidNoFrom()
    {
        $message = new \Swift_Message();

        $message->addTo(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addTo(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setBody(MailWrapperTestBootstrap::$contentText);
        $message->addPart(MailWrapperTestBootstrap::$contentHtml, 'text/html');

        return $message;
    }

    /**
     * @return \Swift_Message
     */
    public static function getNotValidNoSubject()
    {
        $message = new \Swift_Message();

        $message->setFrom(MailWrapperTestBootstrap::$from);
        $message->addTo(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addTo(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setBody(MailWrapperTestBootstrap::$contentText);
        $message->addPart(MailWrapperTestBootstrap::$contentHtml, 'text/html');

        return $message;
    }

    /**
     * @return \Swift_Message
     */
    public static function getNotValidNoTo()
    {
        $message = new \Swift_Message();

        $message->setFrom(MailWrapperTestBootstrap::$from);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setBody(MailWrapperTestBootstrap::$contentText);
        $message->addPart(MailWrapperTestBootstrap::$contentHtml, 'text/html');

        return $message;
    }

    /**
     * @return \Swift_Message
     */
    public static function getValid()
    {
        $message = new \Swift_Message();

        $message->setFrom(MailWrapperTestBootstrap::$from);
        $message->addTo(MailWrapperTestBootstrap::$toAddresses[0]);
        $message->addTo(MailWrapperTestBootstrap::$toAddresses[1]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[0]);
        $message->addCC(MailWrapperTestBootstrap::$ccAddresses[1]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[0]);
        $message->addBCC(MailWrapperTestBootstrap::$bccAddresses[1]);
        $message->addReplyTo(MailWrapperTestBootstrap::$alternate);
        $message->setSubject(MailWrapperTestBootstrap::$subject);
        $message->setBody(MailWrapperTestBootstrap::$contentText);
        $message->addPart(MailWrapperTestBootstrap::$contentHtml, 'text/html');

        return $message;
    }
}
