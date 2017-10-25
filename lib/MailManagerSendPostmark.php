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
use Postmark\Models\PostmarkAttachment;

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

        $attachments = [];
        foreach ($message->getAttachments() as $attachment) {
            $attachments[] = PostmarkAttachment::fromRawData(
                file_get_contents($attachment->file->getRealPath()),
                $attachment->getName()
            );
        }

        $hash = null;
        foreach ($message->getToRecipients() as $recipient) {
            $response = $transport->sendEmail(
                $message->getFrom(),
                $recipient,
                $message->getSubject(),
                $message->getContentHtml(),
                $message->getContentText(),
                $message->template,
                $transport->trackOpen,
                $message->getReplyTo(),
                null,
                null,
                null,
                $attachments
            );
            if ($response && isset($response['MessageID']) && $response['MessageID']) {
                $hash = $response['MessageID'];
            }
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
                $message->getReplyTo(),
                null,
                null,
                null,
                $attachments
            );
            if ($response && isset($response['MessageID']) && $response['MessageID']) {
                $hash = $response['MessageID'];
            }
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
                $message->getReplyTo(),
                null,
                null,
                null,
                $attachments
            );
            if ($response && isset($response['MessageID']) && $response['MessageID']) {
                $hash = $response['MessageID'];
            }
        }

        return ($hash) ? : null;
    }
}
