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
 * Class MailManagerSendSwift
 * @package BespokeSupport\MailWrapper
 */
class MailManagerSendSwift
{
    /**
     * @param \Swift_Mailer|\Swift_Transport $mailer
     * @param \Swift_Mime_Message|MailWrappedMessage $message
     * @return bool|int
     * @throws MailWrapperSetupException
     */
    public static function send($mailer, $message = null)
    {
        if ($mailer instanceof \Swift_Transport) {
            $mailer = new \Swift_Mailer($mailer);
        }

        if (!($mailer instanceof \Swift_Mailer)) {
            throw new MailWrapperSetupException('SwiftMail not Mailer');
        }

        if (!($message instanceof \Swift_Message)) {
            $message = MessageTransformerSwift::fromWrappedMessage($message);
        }

        return $mailer->send($message);
    }
}
