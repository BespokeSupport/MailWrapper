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

/**
 * Class MessageTransformerMailgun
 * @package BespokeSupport\MailWrapper
 */
class MessageTransformerMailgun implements MessageTransformerInterface
{
    /**
     * @inheritDoc
     */
    public static function fromWrappedMessage(MailWrappedMessage $wrappedMessage = null, $transport = null)
    {
        if (!($wrappedMessage instanceof MailWrappedMessage)) {
            throw new MailWrapperSetupException('Not MailWrappedMessage');
        }

        if (!($transport instanceof MailgunManager)) {
            throw new MailWrapperSetupException('Invalid Transport');
        }

        $message = $transport->batch();

        foreach ($wrappedMessage->getToRecipients() as $address) {
            $message->addToRecipient($address);
        }
        foreach ($wrappedMessage->getCcRecipients() as $address) {
            $message->addCcRecipient($address);
        }
        foreach ($wrappedMessage->getBccRecipients() as $address) {
            $message->addBccRecipient($address);
        }

        $message->setFromAddress($wrappedMessage->getFrom());
        $message->setReplyToAddress($wrappedMessage->getReplyTo());
        $message->setSubject($wrappedMessage->getSubject());

        if ($wrappedMessage->getContentText()) {
            $message->setTextBody($wrappedMessage->getContentText());
        }

        if ($wrappedMessage->getContentHtml()) {
            $message->setHtmlBody($wrappedMessage->getContentHtml());
        }

        foreach ($wrappedMessage->getAttachments() as $attachment) {
            $message->addAttachment($attachment->file->getPathname(), $attachment->getName());
        }

        return $message;
    }

    /**
     * @param $message
     * @return bool
     */
    public static function isValid($message)
    {
        if (!$message) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function toWrappedMessage($message)
    {
        if (!($message instanceof MessageBuilder)) {
            throw new MailWrapperSetupException('Invalid Message');
        }

        $wrappedMessage = new MailWrappedMessage();
        $wrappedMessage->setWrappedMessage($message);

        $mailgunMessageArray = $message->getMessage();

        if (array_key_exists('from', $mailgunMessageArray)) {
            foreach ($mailgunMessageArray['from'] as $address) {
                $wrappedMessage->setFrom($address);
            }
        }

        if (array_key_exists('to', $mailgunMessageArray)) {
            foreach ($mailgunMessageArray['to'] as $address) {
                $wrappedMessage->addToRecipient($address);
            }
        }

        if (array_key_exists('cc', $mailgunMessageArray)) {
            foreach ($mailgunMessageArray['cc'] as $address) {
                $wrappedMessage->addCcRecipient($address);
            }
        }

        if (array_key_exists('bcc', $mailgunMessageArray)) {
            foreach ($mailgunMessageArray['bcc'] as $address) {
                $wrappedMessage->addBccRecipient($address);
            }
        }

        if (array_key_exists('subject', $mailgunMessageArray)) {
            $wrappedMessage->setSubject($mailgunMessageArray['subject']);
        }

        if (array_key_exists('text', $mailgunMessageArray)) {
            $wrappedMessage->setContentText($mailgunMessageArray['text']);
        }

        if (array_key_exists('html', $mailgunMessageArray)) {
            $wrappedMessage->setContentHtml($mailgunMessageArray['html']);
        }

        if (array_key_exists('h:reply-to', $mailgunMessageArray)) {
            $wrappedMessage->setReplyTo($mailgunMessageArray['h:reply-to']);
        }

        return $wrappedMessage;
    }
}
