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

use Zend\Mail\Transport\TransportInterface;

/**
 * Class MailManager
 * @package BespokeSupport\MailWrapper
 */
class MailManager
{
    /**
     * @var bool
     */
    private static $debug = false;

    /**
     *
     */
    public static function debug()
    {
        self::$debug = true;
    }
    /**
     * @param string
     * @param string
     * @param string
     * @param array|string
     * @return bool|MailWrappedMessage
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

        $message = new MailWrappedMessage();
        $message->setFrom($fromEmail);
        $message->setSubject($subject);
        $message->setContentText($content);

        foreach ($toEmails as $address) {
            $message->addToRecipient($address);
        }

        return $message;
    }

    /**
     * @param $address
     * @return string|false
     */
    public static function isEmailAddress($address)
    {
        return filter_var($address, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @return array|bool
     * @throws MailWrapperSendException
     * @throws MailWrapperSetupException
     * @throws \Exception
     */
    public static function send()
    {
        $args = func_get_args();

        $message = array_shift($args);

        // re-add message to args as PHPMailer is both transport and message
        if ($message instanceof \PHPMailer) {
            $args[] = $message;
        }

        $message = MessageTransformer::convert($message);

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
                if (self::$debug) {
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
    public static function sendExceptionTo($fromEmail, $subject, \Exception $exception, $toEmails, $transport)
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
    public static function sendTo($fromEmail, $subject, $content, $toEmails, $transport)
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
                return MailManagerSendMailgun::send($transport, $message);
            case ($transport instanceof \PHPMailer):
                return MailManagerSendPhpMailer::send($transport, $message);
            case ($transport instanceof \Swift_Mailer):
            case ($transport instanceof \Swift_Transport):
                return MailManagerSendSwift::send($transport, $message);
            case ($transport instanceof TransportInterface):
                return MailManagerSendZend::send($transport, $message);
            default:
                throw new MailWrapperSetupException('No Transport available');
        }
    }
}
