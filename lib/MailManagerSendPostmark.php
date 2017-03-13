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
 * Class MailManagerSendPostmark
 * @package BespokeSupport\MailWrapper
 */
class MailManagerSendPostmark
{
    /**
     * @param PostmarkManager $transport
     * @param MailWrappedMessage|null $message
     * @return bool|int
     * @throws MailWrapperSetupException
     * @throws \Exception
     * @throws \Mailgun\Messages\Exceptions\TooManyParameters
     */
    public static function send(PostmarkManager $transport, MailWrappedMessage $message = null)
    {
        if (!$message) {
            throw new MailWrapperSetupException('No Message');
        }

        $response = null;
        foreach ($message->getToRecipients() as $recipient) {
            $response = $transport->sendEmail(
                $message->getFrom(),
                $recipient,
                $message->getSubject(),
                $message->getContentHtml(),
                $message->getContentText(),
                $message->template,
                $transport->trackOpen,
                $message->getReplyTo()
            );
        }
        foreach ($message->getCcRecipients() as $recipient) {
            $response = $transport->sendEmail(
                $message->getFrom(),
                $recipient,
                $message->getSubject(),
                $message->getContentHtml(),
                $message->getContentText(),
                $message->template,
                $transport->trackOpen,
                $message->getReplyTo()
            );
        }
        foreach ($message->getBccRecipients() as $recipient) {
            $response = $transport->sendEmail(
                $message->getFrom(),
                $recipient,
                $message->getSubject(),
                $message->getContentHtml(),
                $message->getContentText(),
                $message->template,
                $transport->trackOpen,
                $message->getReplyTo()
            );
        }

        if ($response && isset($response->MessageID)) {
            return $response->MessageID;
        }

        return null;
    }
}
