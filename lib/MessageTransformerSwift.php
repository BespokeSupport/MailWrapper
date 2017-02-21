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
 * Class MessageTransformerSwift
 * @package BespokeSupport\MailWrapper
 */
class MessageTransformerSwift implements MessageTransformerInterface
{
    /**
     * @inheritDoc
     */
    public static function fromWrappedMessage(MailWrappedMessage $wrappedMessage = null, $transport = null)
    {
        if (!($wrappedMessage instanceof MailWrappedMessage)) {
            throw new MailWrapperSetupException('Not MailWrappedMessage');
        }

        $message = new \Swift_Message();

        foreach ($wrappedMessage->getToRecipients() as $address) {
            $message->addTo($address);
        }
        foreach ($wrappedMessage->getCcRecipients() as $address) {
            $message->addCc($address);
        }
        foreach ($wrappedMessage->getBccRecipients() as $address) {
            $message->addBcc($address);
        }

        $message->setReplyTo($wrappedMessage->getReplyTo());
        $message->setFrom($wrappedMessage->getFrom());
        $message->setSubject($wrappedMessage->getSubject());

        if ($wrappedMessage->getContentText()) {
            $message->setBody($wrappedMessage->getContentText(), 'text/plain');
        }

        if ($wrappedMessage->getContentHtml()) {
            $message->addPart($wrappedMessage->getContentHtml(), 'text/html');
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
    public static function toWrappedMessage($message, $transport = null)
    {
        if (!($message instanceof \Swift_Message)) {
            throw new MailWrapperSetupException('Invalid Message');
        }

        $wrappedMessage = new MailWrappedMessage();
        $wrappedMessage->setWrappedMessage($message);

        $subject = $message->getSubject();
        $content = $message->getBody();

        $toRecipients = $message->getTo();
        $ccRecipients = $message->getCc();
        $bccRecipients = $message->getBcc();


        $from = ($message->getFrom()) ? key($message->getFrom()) : null;
        $replyTo = ($message->getReplyTo()) ? key($message->getReplyTo()) : null;

        //

        $wrappedMessage->setSubject($subject);
        $wrappedMessage->setContentText($content);

        $address = MailManager::isEmailAddress($from);
        if ($address) {
            $wrappedMessage->setFrom($address);
        }

        $address = MailManager::isEmailAddress($replyTo);
        if ($address) {
            $wrappedMessage->setReplyTo($address);
        }

        if ($toRecipients) {
            foreach (array_keys($toRecipients) as $address) {
                $wrappedMessage->addToRecipient($address);
            }
        }

        if ($ccRecipients) {
            foreach (array_keys($ccRecipients) as $address) {
                $wrappedMessage->addCcRecipient($address);
            }
        }

        if ($bccRecipients) {
            foreach (array_keys($bccRecipients) as $address) {
                $wrappedMessage->addBccRecipient($address);
            }
        }

        return $wrappedMessage;
    }
}
