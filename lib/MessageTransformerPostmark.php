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

use Postmark\Attachment;
use Postmark\Inbound;

/**
 * Class MessageTransformerPostmark
 * @package BespokeSupport\MailWrapper
 */
class MessageTransformerPostmark implements MessageTransformerInterface
{
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
        if (!($message instanceof Inbound)) {
            throw new MailWrapperSetupException('Invalid Message');
        }

        $wrappedMessage = new MailWrappedMessage();
        $wrappedMessage->setWrappedMessage($message);

        $wrappedMessage->setReplyTo($message->ReplyTo());
        $wrappedMessage->setFrom($message->FromEmail());
        $wrappedMessage->setSubject($message->Subject());
        $wrappedMessage->setContentHtml($message->HtmlBody());
        $wrappedMessage->setContentText($message->TextBody());

        if (count($message->ToFull())) {
            foreach ($message->ToFull() as $recipient) {
                $wrappedMessage->addToRecipient($recipient->Email);
            }
        }

        if (count($message->CcFull())) {
            foreach ($message->CcFull() as $recipient) {
                $wrappedMessage->addCcRecipient($recipient->Email);
            }
        }

        if (count($message->BccFull())) {
            foreach ($message->BccFull() as $recipient) {
                $wrappedMessage->addBccRecipient($recipient->Email);
            }
        }

        /**
         * @var Attachment[] $attachments
         */
        $attachments = $message->Attachments();
        foreach ($attachments as $attachment) {
            $name = $attachment->Name;
            $attachment->Download(sys_get_temp_dir() . DIRECTORY_SEPARATOR);

            $newFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $name;
            $new = new MessageAttachment(new \SplFileInfo($newFile), $name);
            $wrappedMessage->addAttachment($new);
        }

        return $wrappedMessage;
    }

    /**
     * @inheritDoc
     */
    public static function fromWrappedMessage(MailWrappedMessage $wrappedMessage = null, $transport = null)
    {
        if (!($wrappedMessage instanceof MailWrappedMessage)) {
            throw new MailWrapperSetupException('Not MailWrappedMessage');
        }

        $data = PostmarkManager::getInboundData();

        $data->From = $wrappedMessage->getFrom();
        $data->FromFull = PostmarkManager::getAddress($wrappedMessage->getFrom());

        $data->TextBody = $wrappedMessage->getContentText();
        $data->HtmlBody = $wrappedMessage->getContentHtml();
        $data->Subject = $wrappedMessage->getSubject();
        $data->ReplyTo = $wrappedMessage->getReplyTo();

        foreach ($wrappedMessage->getToRecipients() as $recipient) {
            $data->ToFull[] = PostmarkManager::getAddress($recipient);
        }

        foreach ($wrappedMessage->getCcRecipients() as $recipient) {
            $data->CcFull[] = PostmarkManager::getAddress($recipient);
        }

        foreach ($wrappedMessage->getBccRecipients() as $recipient) {
            $data->BccFull[] = PostmarkManager::getAddress($recipient);
        }

        $now = new \DateTime();
        $data->Date = $now->format('r');

        // TODO - attachments

        $message = new Inbound(json_encode($data));

        return $message;
    }
}
