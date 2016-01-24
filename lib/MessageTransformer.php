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

use Mailgun\Messages\MessageBuilder;
use Zend\Mail\Message;

/**
 * Class MessageTransformer
 * @package BespokeSupport\MailWrapper
 */
class MessageTransformer
{
    /**
     * @param $message
     * @param string $destination
     * @param null $transport
     * @return MailgunMessage|\PHPMailer|\Swift_Message|Message
     * @throws MailWrapperSetupException
     */
    public static function convert($message, $destination = 'wrappedMessage', $transport = null)
    {
        switch (true) {
            case ($message instanceof MailWrappedMessage):
                break;
            case ($message instanceof Message):
                $message = MessageTransformerZend::toWrappedMessage($message);
                break;
            case ($message instanceof MessageBuilder):
                $message = MessageTransformerMailgun::toWrappedMessage($message);
                break;
            case ($message instanceof \PHPMailer):
                $message = MessageTransformerPhpMailer::toWrappedMessage($message);
                break;
            case ($message instanceof \Swift_Message):
                $message = MessageTransformerSwift::toWrappedMessage($message);
                break;
            default:
                throw new MailWrapperSetupException('No Message Converter');
        }

        switch ($destination) {
            case 'mailgun':
                return MessageTransformerMailgun::fromWrappedMessage($message, $transport);
            case 'phpmailer':
                return MessageTransformerPhpMailer::fromWrappedMessage($message);
            case 'swift':
                return MessageTransformerSwift::fromWrappedMessage($message);
            case 'zend':
                return MessageTransformerZend::fromWrappedMessage($message);
            case 'wrappedMessage':
                return $message;
            default:
                throw new MailWrapperSetupException('No Message Converter');
        }
    }

    /**
     * @param $message
     * @return MailWrappedMessage
     * @throws MailWrapperSetupException
     */
    public static function getWrappedMessage($message)
    {
        switch (true) {
            case ($message instanceof MailWrappedMessage):
                return $message;
            case ($message instanceof Message):
                return MessageTransformerZend::toWrappedMessage($message);
            case ($message instanceof MessageBuilder):
                return MessageTransformerMailgun::toWrappedMessage($message);
            case ($message instanceof \PHPMailer):
                return MessageTransformerPhpMailer::toWrappedMessage($message);
            case ($message instanceof \Swift_Message):
                return MessageTransformerSwift::toWrappedMessage($message);
            default:
                throw new MailWrapperSetupException('No Message Converter');
        }
    }
}
