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
 * Class MessageTransformerPhpMailer
 * @package BespokeSupport\MailWrapper
 */
class MessageTransformerPhpMailer implements MessageTransformerInterface
{
    /**
     * @inheritDoc
     */
    public static function fromWrappedMessage(MailWrappedMessage $wrappedMessage = null, $transport = null)
    {
        if (!($wrappedMessage instanceof MailWrappedMessage)) {
            throw new MailWrapperSetupException('Not MailWrappedMessage');
        }

        $message = new \PHPMailer();

        foreach ($wrappedMessage->getToRecipients() as $address) {
            $message->addAddress($address);
        }
        foreach ($wrappedMessage->getCcRecipients() as $address) {
            $message->addCC($address);
        }
        foreach ($wrappedMessage->getBccRecipients() as $address) {
            $message->addBCC($address);
        }

        $message->Subject = $wrappedMessage->getSubject();
        $message->Body = $wrappedMessage->getContentHtml();
        $message->AltBody = $wrappedMessage->getContentText();

        return $message;
    }

    /**
     * @param $message \PHPMailer
     * @return bool
     */
    public static function isValid($message)
    {
        if (!$message) {
            return false;
        }

        if (!count($message->getToAddresses())) {
            return false;
        }

        return true;
    }

    /**
     * @param $message \PHPMailer
     * @param $wrappedMessage MailWrappedMessage|\PHPMailer
     * @return mixed
     * @throws MailWrapperSetupException
     */
    public static function merge($message, $wrappedMessage)
    {
        if (!($wrappedMessage instanceof MailWrappedMessage)) {
            $wrappedMessage = self::toWrappedMessage($message);
        }

        $message->From = $wrappedMessage->getFrom();
        foreach ($wrappedMessage->getToRecipients() as $address) {
            $message->addAddress($address);
        }

        $message->Body = $wrappedMessage->getContentHtml();
        $message->AltBody = $wrappedMessage->getContentText();

        return $message;
    }

    /**
     * @inheritDoc
     */
    public static function toWrappedMessage($message, $transport = null)
    {
        if (!($message instanceof \PHPMailer)) {
            throw new MailWrapperSetupException('Invalid Message');
        }

        $wrappedMessage = new MailWrappedMessage();
        $wrappedMessage->setWrappedMessage($message);

        $subject = $message->Subject;
        $content = $message->Body;
        $from = $message->From;
        $toRecipients = $message->getToAddresses();
        $ccRecipients = $message->getCcAddresses();
        $bccRecipients = $message->getBccAddresses();
        $replyToAddresses = $message->getReplyToAddresses();

        //

        $wrappedMessage->setSubject($subject);
        $wrappedMessage->setContentText($content);

        $address = MailManager::isEmailAddress($from);
        if ($address) {
            $wrappedMessage->setFrom($address);
        }

        foreach ($replyToAddresses as $address) {
            $wrappedMessage->setReplyTo($address[0]);
        }

        foreach ($toRecipients as $address) {
            $wrappedMessage->addToRecipient($address[0]);
        }

        foreach ($ccRecipients as $address) {
            $wrappedMessage->addCcRecipient($address[0]);
        }

        foreach ($bccRecipients as $address) {
            $wrappedMessage->addBccRecipient($address[0]);
        }

        return $wrappedMessage;
    }
}
