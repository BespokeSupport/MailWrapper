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

use Mailgun\Messages\BatchMessage;
use Mailgun\Messages\MessageBuilder;
use Zend\Mail\Message;

/**
 * Class MessageTransformer
 * @package BespokeSupport\MailWrapper
 */
class MessageTransformer
{
    /**
     * @param string $destination
     * @param $message
     * @param null $transport
     * @return MailgunMessage|\Swift_Mailer|\Swift_Message
     * @throws MailWrapperSetupException
     */
    public static function convert($destination = 'swift', $message, $transport = null)
    {
        switch ($destination) {
            case 'swift':
                switch (true) {
                    case ($message instanceof \PHPMailer):
                        return static::phpMailerToSwift($message);
                    case ($message instanceof Message):
                        return static::zendToSwift($message);
                    case ($message instanceof MessageBuilder):
                    case ($message instanceof BatchMessage):
                    case ($message instanceof MailgunMessage):
                        return static::mailgunToSwift($message);
                    default:
                        throw new MailWrapperSetupException('No Message Converter');
                }
                break;
            case 'mailgun':
                switch (true) {
                    case ($message instanceof \PHPMailer):
                        return static::phpMailerToMailgun($message, $transport);
                    case ($message instanceof \Swift_Message):
                        return static::swiftToMailgun($message, $transport);
                    case ($message instanceof Message):
                        return static::zendToMailgun($message, $transport);
                    default:
                        throw new MailWrapperSetupException('No Message Converter');
                }
                break;
            default:
                throw new MailWrapperSetupException('No Message Converter');
        }
    }

    /**
     * @param MessageBuilder $mailgunMessage
     * @return bool|\Swift_Message
     * @throws MailWrapperSetupException
     */
    public static function mailgunToSwift(MessageBuilder $mailgunMessage)
    {
        $mailgunMessageArray = $mailgunMessage->getMessage();

        if (!array_key_exists('from', $mailgunMessageArray)) {
            throw new MailWrapperSetupException('No FROM Address');
        }

        if (!array_key_exists('subject', $mailgunMessageArray)) {
            throw new MailWrapperSetupException('No Subject');
        }

        if (!array_key_exists('text', $mailgunMessageArray) && !array_key_exists('html', $mailgunMessageArray)) {
            throw new MailWrapperSetupException('No Body');
        }

        if (!array_key_exists('to', $mailgunMessageArray) || !count($mailgunMessageArray['to'])) {
            throw new MailWrapperSetupException('No TO Address(es)');
        }

        $message = MailManager::getMailMessage(
            $mailgunMessageArray['from'],
            $mailgunMessageArray['subject'],
            $mailgunMessageArray['text'],
            $mailgunMessageArray['to']
        );

        if (array_key_exists('cc', $mailgunMessageArray)) {
            foreach ($mailgunMessageArray['cc'] as $address) {
                $message->addCc($address);
            }
        }

        if (array_key_exists('bcc', $mailgunMessageArray)) {
            foreach ($mailgunMessageArray['bcc'] as $address) {
                $message->addBcc($address);
            }
        }

        return $message;
    }

    /**
     * @param \PHPMailer $mailer
     * @return \Swift_Mailer
     * @throws MailWrapperSetupException
     */
    public static function phpMailerToSwift(\PHPMailer $mailer)
    {
        $message = \Swift_Message::newInstance(
            $mailer->Subject,
            $mailer->Body
        );

        $addresses = $mailer->getToAddresses();
        if (!count($addresses)) {
            throw new MailWrapperSetupException('No TO Address(es)');
        }
        foreach ($addresses as $address) {
            $message->addTo($address[0]);
        }

        $addresses = $mailer->getCcAddresses();
        foreach ($addresses as $address) {
            $message->addCc($address[0]);
        }

        $addresses = $mailer->getBccAddresses();
        foreach ($addresses as $address) {
            $message->addBcc($address[0]);
        }

        $addresses = $mailer->getReplyToAddresses();
        foreach ($addresses as $address) {
            $message->addReplyTo($address[0]);
        }

        return $message;
    }

    /**
     * @param \PHPMailer $mailer
     * @param MailgunManager $transport
     * @return MailgunMessage
     * @throws MailWrapperSetupException
     */
    public static function phpMailerToMailgun(\PHPMailer $mailer, MailgunManager $transport)
    {
        $message = $transport->batch();
        $message->setFromAddress($mailer->From);
        $message->setTextBody($mailer->Body);
        $message->setHtmlBody($mailer->AltBody);

        $addresses = $mailer->getToAddresses();
        if (!count($addresses)) {
            throw new MailWrapperSetupException('No TO Address(es)');
        }
        foreach ($addresses as $address) {
            $message->addToRecipient($address[0]);
        }

        $addresses = $mailer->getCcAddresses();
        foreach ($addresses as $address) {
            $message->addCcRecipient($address[0]);
        }

        $addresses = $mailer->getBccAddresses();
        foreach ($addresses as $address) {
            $message->addBccRecipient($address[0]);
        }

        return $message;
    }

    /**
     * @param \Swift_Mime_Message $message
     * @param MailgunManager $transport
     * @return MailgunMessage
     * @throws MailWrapperSetupException
     */
    public static function swiftToMailgun(\Swift_Mime_Message $message, $transport)
    {
        if (!($transport instanceof MailgunManager)) {
            throw new MailWrapperSetupException('Transport must be MailgunManager');
        }

        $batch = $transport->batch();
        $batch->setSubject($message->getSubject());
        $batch->setHtmlBody(nl2br($message->getBody()));

        // emails
        $from = $message->getFrom();
        $batch->setFromAddress(key($from));
        $batch->setReplyToAddress($message->getReplyTo());

        $toMails = $message->getTo();
        if (!is_array($toMails)) {
            throw new MailWrapperSetupException('No TO addresses');
        }

        foreach (array_keys($toMails) as $email) {
            if ($batch->getRecipientCount('to') >= MailgunMessage::RECIPIENT_COUNT_LIMIT) {
                throw new MailWrapperSetupException(
                    'Recipient cannot exceed: ' . MailgunMessage::RECIPIENT_COUNT_LIMIT
                );
            }

            $batch->addToRecipient($email, []);
        }

        if ($message->getCc()) {
            foreach (array_keys($message->getCc()) as $email) {
                $batch->addCcRecipient($email, []);
            }
        }

        if ($message->getBcc()) {
            foreach (array_keys($message->getBcc()) as $email) {
                $batch->addBccRecipient($email, []);
            }
        }

        return $batch;
    }

    /**
     * @param Message $message
     * @return \Swift_Message
     */
    public static function zendToSwift(Message $message)
    {
        $message = \Swift_Message::newInstance(
            $message->getSubject(),
            (($message->getBody()) ?: $message->getBodyText())
        );

        // TODO

        return $message;
    }

    /**
     * @param Message $zendMessage
     * @param MailgunManager $transport
     * @return MailgunMessage
     * @throws MailWrapperSetupException
     */
    public static function zendToMailgun(Message $zendMessage, $transport)
    {
        if (!($transport instanceof MailgunManager)) {
            throw new MailWrapperSetupException('Transport must be MailgunManger');
        }

        $message = $transport->batch();

        $from = $zendMessage->getFrom()->current();
        if (!$from) {
            throw new MailWrapperSetupException('No FROM');
        }

        $message->setFromAddress($from->getEmail());

        // TODO

        return $message;
    }
}
