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

use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

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
            $message = MessageTransformer::phpMailerToSwift($message);
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

        $exceptionClass = get_class($exception);

        $content = '';

        $content .= "Except:\t" . $exceptionClass . PHP_EOL;
        $content .= "Error:\t" . $exception->getMessage() . PHP_EOL;
        $content .= "File:\t" . $exception->getFile() . PHP_EOL;
        $content .= "Line:\t" . $exception->getLine() . PHP_EOL;

        if ($exception instanceof MailWrapperMailableException) {
            $content .= PHP_EOL . 'Params:' . PHP_EOL;
            $content .= print_r($exception->getParams(), true);
        }

        $content .= PHP_EOL . PHP_EOL;
        $content .= 'Trace:' . PHP_EOL . PHP_EOL;
        $content .= $exception->getTraceAsString();

        $message = static::getMailMessage($fromEmail, $subject, $content, $toEmails);

        return static::sendVia($transport, $message);
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

        return static::sendVia($transport, $message);
    }

    /**
     * @param $transport
     * @param $message
     * @return bool|int
     * @throws MailWrapperSetupException
     */
    public static function sendVia($transport, $message = null)
    {
        switch (true) {
            case ($transport instanceof MailgunManager):
                return static::sendViaMailgun($transport, $message);
            case ($transport instanceof \Swift_Mailer):
                return static::sendViaSwiftMailer($transport, $message);
            case ($transport instanceof \Swift_Transport):
                return static::sendViaSwiftMailer($transport, $message);
            case ($transport instanceof \PHPMailer):
                return static::sendViaPhpMailer($transport, $message);
            case ($transport instanceof TransportInterface):
                return static::sendViaZend($transport, $message);
            default:
                throw new MailWrapperSetupException('No Transport available');
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

        $batch = MessageTransformer::swiftToMailgun($message, $transport);

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
     * @param \PHPMailer $mailer
     * @param null $message
     * @return bool
     * @throws MailWrapperSendException
     * @throws MailWrapperSetupException
     */
    public static function sendViaPhpMailer(\PHPMailer $mailer, $message = null)
    {
        if (!$mailer->From && $message) {
            // todo merge message with transport
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

    /**
     * @param TransportInterface $transport
     * @param Message|null $message
     * @return mixed
     * @throws MailWrapperSetupException
     */
    public static function sendViaZend(TransportInterface $transport, $message = null)
    {
        if (!($message instanceof Message)) {
            throw new MailWrapperSetupException('Message not constructed');
        }

        return $transport->send($message);
    }
}
