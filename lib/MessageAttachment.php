<?php
/**
 * Message Attachment
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
 * Class MessageAttachment
 * @package BespokeSupport\MailWrapper
 */
class MessageAttachment
{
    public $file;
    public $name;

    /**
     * MessageAttachment constructor.
     * @param \SplFileInfo $file
     * @param null $name
     */
    public function __construct(\SplFileInfo $file, $name = null)
    {
        $this->file = $file;
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        if (!$this->name) {
            return $this->file->getFilename();
        }

        return $this->name;
    }
}
