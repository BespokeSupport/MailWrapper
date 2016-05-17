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

/**
 * Class MailgunMessage
 * @package BespokeSupport\MailWrapper
 */
class MailgunMessage extends BatchMessage
{
    const RECIPIENT_COUNT_LIMIT = 1000;

    /**
     * @param $address
     * @param null $variables
     * @return mixed
     * @throws \Mailgun\Messages\Exceptions\TooManyParameters
     */
    public function addBccRecipient($address, $variables = null)
    {
        if (is_null($variables)) {
            $variables = [];
        }
        return parent::addBccRecipient($address, $variables);
    }

    /**
     * @param $address
     * @param null $variables
     * @return mixed
     * @throws \Mailgun\Messages\Exceptions\TooManyParameters
     */
    public function addCcRecipient($address, $variables = null)
    {
        if (is_null($variables)) {
            $variables = [];
        }
        return parent::addCcRecipient($address, $variables);
    }

    /**
     * @param $address
     * @param null $variables
     * @return mixed
     * @throws \Mailgun\Messages\Exceptions\TooManyParameters
     */
    public function addToRecipient($address, $variables = null)
    {
        if (is_null($variables)) {
            $variables = [];
        }
        return parent::addToRecipient($address, $variables);
    }

    /**
     * @param $field
     * @return mixed
     * @throws MailWrapperSetupException
     */
    public function getRecipientCount($field)
    {
        if (!in_array($field, ['to', 'cc', 'bcc'])) {
            throw new MailWrapperSetupException('Not "to", "cc", "bcc"');
        }

        return $this->counters['recipients'][$field];
    }

    /**
     * @return null|string
     */
    public function send()
    {
        $this->sendMessage();

        $ids = $this->getMessageIds();

        if (count($ids)) {
            return $ids[0];
        }

        return null;
    }
}
