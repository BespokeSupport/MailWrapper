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
 * Class MailManager
 * @package BespokeSupport\MailWrapper
 */
class MailManager
{
    /**
     * @param string
     * @param string
     * @param string
     * @param array|string
     * @return bool|\Swift_Message
     * @throws MailWrapperSetupException
     */
    public static function getMailMessage()
    {
        $args = func_get_args();

        $fromEmail = array_shift($args);
        $subject = array_shift($args);
        $content = array_shift($args);

        $toEmails = MailAddressManager::combineRecipients($args);

        if (!count($toEmails)) {
            return false;
        }

        if (!class_exists('Swift_Message')) {
            //@codeCoverageIgnoreStart
            throw new MailWrapperSetupException('SwiftMail not found');
            //@codeCoverageIgnoreEnd
        }

        $message = \Swift_Message::newInstance();

        $message
            ->setFrom($fromEmail)
            ->setSubject($subject)
            ->setBody($content);

        $message->setTo($toEmails);

        return $message;
    }

    /**
     * @return array|bool
     * @throws MailWrapperSendException
     * @throws MailWrapperSetupException
     */
    public static function send()
    {
        $args = func_get_args();

        $message = array_shift($args);

        if ($message instanceof \PHPMailer) {
            $args[] = $message;
            $message = MessageTransformer::phpMailerToSwiftMessage($message);
        }

        if (!($message instanceof \Swift_Mime_Message)) {
            throw new MailWrapperSetupException('Message must be a Swift_Message');
        }

        if (!count($args)) {
            throw new MailWrapperSetupException('No Transports available');
        }

        foreach ($args as $transport) {
            if (!$transport) {
                throw new MailWrapperSetupException('NULL Transport');
            }
            try {
                return static::sendVia($transport, $message);
            } catch (\Exception $e) {
                if ($e instanceof MailWrapperSetupException) {
                    throw $e;
                }
                continue;
            }
        }

        throw new MailWrapperSendException('No Transports succeeded');
    }

    /**
     * @param $transport
     * @param $fromEmail
     * @param $subject
     * @param \Exception $exception
     * @param array $toEmails
     * @return bool|int
     * @throws MailWrapperSetupException
     */
    public static function sendExceptionTo($transport, $fromEmail, $subject, \Exception $exception, $toEmails)
    {
        if (!$toEmails) {
            throw new MailWrapperSetupException('No TO emails provided');
        }

        $content = '';

        $content .= $exception->getMessage();

        $message = static::getMailMessage($fromEmail, $subject, $content, $toEmails);

        return static::send($transport, $message);
    }

    /**
     * @param $transport
     * @param $fromEmail
     * @param $subject
     * @param $content
     * @param array $toEmails
     * @return bool|int
     * @throws MailWrapperSetupException
     */
    public static function sendTo($transport, $fromEmail, $subject, $content, $toEmails)
    {
        if (!$toEmails) {
            throw new MailWrapperSetupException('No TO emails provided');
        }

        $message = static::getMailMessage($fromEmail, $subject, $content, $toEmails);

        return static::send($transport, $message);
    }

    /**
     * @param $transport
     * @param $message
     * @return bool|int
     * @throws MailWrapperSetupException
     */
    public static function sendVia($transport, $message)
    {
        switch (true) {
            case ($transport instanceof MailgunManager):
                return static::sendViaMailgun($transport, $message);
                break;
            case ($transport instanceof \Swift_Mailer):
                return static::sendViaSwiftMailer($transport, $message);
                break;
            case ($transport instanceof \Swift_Transport):
                return static::sendViaSwiftMailer($transport, $message);
                break;
            case ($transport instanceof \PHPMailer):
                return static::sendViaPhpMailer($transport, $message);
                break;
            default:
                throw new MailWrapperSetupException('No Transport available');
        }
    }

    /**
     * @param \PHPMailer $mailer
     * @param $message
     * @return bool
     * @throws MailWrapperSendException
     * @throws MailWrapperSetupException
     */
    public static function sendViaPhpMailer(\PHPMailer $mailer, $message)
    {
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

    /**
     * @param MailgunManager $transport
     * @param \Swift_Mime_Message|null $message
     * @return bool|int
     * @throws MailWrapperSetupException
     * @throws \Exception
     * @throws \Mailgun\Messages\Exceptions\TooManyParameters
     */
    public static function sendViaMailgun(MailgunManager $transport, \Swift_Mime_Message $message = null)
    {
        if (!$message) {
            throw new MailWrapperSetupException('No Message');
        }

        $batch = MessageTransformer::swiftMessageToMailGunBatch($message, $transport);

        try {
            $batch->finalize();
        } catch (\Exception $e) {
            throw new MailWrapperSendException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }

        $ids = $batch->getMessageIds();

        return ((1 == count($ids))) ? $ids[0] : false;
    }

    /**
     * @param \Swift_Mailer|\Swift_Transport $mailer
     * @param \Swift_Mime_Message|null $message
     * @return bool|int
     * @throws MailWrapperSetupException
     */
    public static function sendViaSwiftMailer($mailer, $message = null)
    {
        if ($mailer instanceof \Swift_Transport) {
            $mailer = \Swift_Mailer::newInstance($mailer);
        }

        if (!($mailer instanceof \Swift_Mailer)) {
            throw new MailWrapperSetupException('SwiftMail not Mailer');
        }

        if (!($message instanceof \Swift_Message)) {
            throw new MailWrapperSetupException('Message not constructed');
        }

        return $mailer->send($message);
    }
}
