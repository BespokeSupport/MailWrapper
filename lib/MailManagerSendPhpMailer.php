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
 * Class MailManagerSendPhpMailer
 * @package BespokeSupport\MailWrapper
 */
class MailManagerSendPhpMailer
{
    /**
     * @param \PHPMailer $mailer
     * @param null $message
     * @return bool
     * @throws MailWrapperSendException
     * @throws MailWrapperSetupException
     */
    public static function send(\PHPMailer $mailer, $message = null)
    {
        if (!MessageTransformerPhpMailer::isValid($mailer) && $message) {
            $mailer = MessageTransformerPhpMailer::merge($mailer, $message);
        }

        try {
            $mailer->preSend();
        } catch (\Exception $e) {
            throw new MailWrapperSetupException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }

        try {
            return $mailer->postSend();
        } catch (\Exception $e) {
            throw new MailWrapperSendException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
