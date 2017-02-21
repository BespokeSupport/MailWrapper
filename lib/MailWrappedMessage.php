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
use PHPMailer;
use Swift_Message;
use Zend\Mail\Message;

/**
 * Class MailWrappedMessage
 * @package BespokeSupport\MailWrapper
 */
class MailWrappedMessage
{
    /**
     * @var array
     */
    protected $bccRecipients = [];
    /**
     * @var array
     */
    protected $ccRecipients = [];
    /**
     * @var string
     */
    protected $contentHtml;
    /**
     * @var string
     */
    protected $contentText;
    /**
     * @var string
     */
    protected $from;
    /**
     * @var string
     */
    protected $replyTo;
    /**
     * @var string
     */
    protected $subject;
    /**
     * @var array
     */
    protected $toRecipients = [];
    /**
     * @var Swift_Message|PHPMailer|MessageBuilder|Message
     */
    protected $wrappedMessage;

    /**
     * @var string
     */
    public $template;

    /**
     * MailWrappedMessage constructor.
     * @param $message MailWrappedMessage
     * @return MailWrappedMessage|self
     * @throws MailWrapperSetupException
     */
    public function __construct($message = null)
    {
        if ($message) {
            if (!($message instanceof MailWrappedMessage)) {
                $this->wrappedMessage = $message;
                $message = MessageTransformer::getWrappedMessage($message);
            }

            $this->subject = $message->getSubject();
            $this->from = $message->getFrom();
            $this->replyTo = $message->getReplyTo();
            $this->contentText = $message->getContentText();
            $this->contentHtml = $message->getContentHtml();
            $this->setToRecipients($message->getToRecipients());
            $this->setCcRecipients($message->getCcRecipients());
            $this->setBccRecipients($message->getBccRecipients());
        }
    }

    /**
     * @param $address
     * @return bool
     */
    public function addBccRecipient($address)
    {
        if (!$address) {
            return false;
        }

        if (!($address = MailManager::isEmailAddress($address))) {
            return false;
        }

        if (in_array($address, $this->bccRecipients)) {
            return false;
        }

        $this->bccRecipients[] = $address;

        return true;
    }

    /**
     * @param $address
     * @return bool
     */
    public function addCcRecipient($address)
    {
        if (!$address) {
            return false;
        }

        if (!($address = MailManager::isEmailAddress($address))) {
            return false;
        }

        if (in_array($address, $this->ccRecipients)) {
            return false;
        }

        $this->ccRecipients[] = $address;

        return true;
    }

    /**
     * @param $address
     * @return bool
     */
    public function addToRecipient($address)
    {
        if (!$address) {
            return false;
        }

        if (!($address = MailManager::isEmailAddress($address))) {
            return false;
        }

        if (in_array($address, $this->toRecipients)) {
            return false;
        }

        $this->toRecipients[] = $address;

        return true;
    }

    /**
     * @return array
     */
    public function getBccRecipients()
    {
        return $this->bccRecipients;
    }

    /**
     * @return array
     */
    public function getCcRecipients()
    {
        return $this->ccRecipients;
    }

    /**
     * @return string
     */
    public function getContentHtml()
    {
        return $this->contentHtml;
    }

    /**
     * @return string
     */
    public function getContentText()
    {
        return $this->contentText;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return MessageBuilder|PHPMailer|Swift_Message|Message
     */
    public function getMessage()
    {
        return $this->wrappedMessage;
    }

    /**
     * @return string
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return array
     */
    public function getToRecipients()
    {
        return $this->toRecipients;
    }

    /**
     * @return null|MessageBuilder|PHPMailer|Swift_Message|Message
     */
    public function getWrappedMessage()
    {
        return $this->getMessage();
    }

    /**
     * @param null $message
     * @return MailWrappedMessage
     * @throws MailWrapperSetupException
     */
    public static function newInstance($message = null)
    {
        switch (true) {
            case ($message instanceof Swift_Message):
            case ($message instanceof PHPMailer):
            case ($message instanceof MessageBuilder):
            case ($message instanceof Message):
            case ($message instanceof MailWrappedMessage):
                $message = MessageTransformer::getWrappedMessage($message);
                break;
            case ($message):
                throw new MailWrapperSetupException('Unknown Message');
            default:
                break;
        }

        return new self($message);
    }

    /**
     * @param array $addresses
     */
    public function setBccRecipients(array $addresses = [])
    {
        foreach ($addresses as $address) {
            $this->addBccRecipient($address);
        }
    }

    /**
     * @param array $addresses
     */
    public function setCcRecipients(array $addresses = [])
    {
        foreach ($addresses as $address) {
            $this->addCcRecipient($address);
        }
    }

    /**
     * @param string $contentHtml
     */
    public function setContentHtml($contentHtml)
    {
        $this->contentHtml = trim($contentHtml);
    }

    /**
     * @param string $contentText
     */
    public function setContentText($contentText)
    {
        $this->contentText = trim($contentText);
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;

        if (!$this->replyTo) {
            $this->replyTo = $from;
        }
    }

    /**
     * @param string $replyTo
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = trim($subject);
    }

    /**
     * @param array $addresses
     */
    public function setToRecipients(array $addresses = [])
    {
        foreach ($addresses as $address) {
            $this->addToRecipient($address);
        }
    }

    /**
     * @param $message
     */
    public function setWrappedMessage($message)
    {
        $this->wrappedMessage = $message;
    }
}
