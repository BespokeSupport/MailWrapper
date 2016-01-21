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
 * Class MessageTransformer
 * @package BespokeSupport\MailWrapper
 */
class MessageTransformer
{
    /**
     * @param \Swift_Mime_Message $message
     * @param MailgunManager $transport
     * @return MailgunMessage
     * @throws MailWrapperSetupException
     */
    public static function swiftMessageToMailGunBatch(\Swift_Mime_Message $message, MailgunManager $transport)
    {
        $batch = $transport->batch();
        $batch->setSubject($message->getSubject());
        $batch->setHtmlBody($message->getBody());

        // emails
        $from = $message->getFrom();
        $batch->setFromAddress(key($from));
        $batch->setReplyToAddress($message->getReplyTo());

        foreach ($message->getTo() as $email) {
            if ($batch->getRecipientCount('to') >= MailgunMessage::RECIPIENT_COUNT_LIMIT) {
                throw new MailWrapperSetupException(
                    'Recipient cannot exceed: ' . MailgunMessage::RECIPIENT_COUNT_LIMIT
                );
            }
            $batch->addToRecipient($email, []);
        }

        if ($message->getCc()) {
            foreach ($message->getCc() as $email) {
                $batch->addCcRecipient($email, []);
            }
        }

        if ($message->getBcc()) {
            foreach ($message->getBcc() as $email) {
                $batch->addBccRecipient($email, []);
            }
        }

        return $batch;
    }

    /**
     * @param \PHPMailer $mailer
     * @return \Swift_Mailer
     */
    public static function phpMailerToSwiftMessage(\PHPMailer $mailer)
    {
        $message = \Swift_Message::newInstance(
            $mailer->Subject,
            $mailer->Body
        );

        // TODO

        return $message;
    }
}
