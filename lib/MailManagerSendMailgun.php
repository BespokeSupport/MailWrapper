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
 * Class MailManagerSendMailgun
 * @package BespokeSupport\MailWrapper
 */
class MailManagerSendMailgun
{
    /**
     * @param MailgunManager $transport
     * @param MailWrappedMessage|null $message
     * @return bool|int
     * @throws MailWrapperSetupException
     * @throws \Exception
     * @throws \Mailgun\Messages\Exceptions\TooManyParameters
     */
    public static function send(MailgunManager $transport, MailWrappedMessage $message = null)
    {
        if (!$message) {
            throw new MailWrapperSetupException('No Message');
        }

        if (MailgunMessage::RECIPIENT_COUNT_LIMIT <= count($message->getToRecipients())) {
            throw new MailWrapperSetupException(MailgunMessage::RECIPIENT_COUNT_LIMIT . ' limit exceeded');
        }

        $batch = MessageTransformerMailgun::fromWrappedMessage($message, $transport);

        try {
            $batch->finalize();
        } catch (\Exception $e) {
            throw new MailWrapperSendException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }

        $ids = $batch->getMessageIds();

        return ((1 == count($ids))) ? $ids[0] : false;
    }
}
