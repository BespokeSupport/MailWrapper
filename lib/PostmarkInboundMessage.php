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
 * Class PostmarkManager
 * @package BespokeSupport\MailWrapper
 */
class PostmarkInboundMessage extends \stdClass
{
    /**
     * @var \stdClass
     */
    public $FromFull = null;
    /**
     * @var PostmarkAddress[]
     */
    public $ToFull = [];
    /**
     * @var PostmarkAddress[]
     */
    public $CcFull = [];
    /**
     * @var PostmarkAddress[]
     */
    public $BccFull = [];
    public $FromName = null;
    public $From = null;
    public $To = null;
    public $Cc = null;
    public $Bcc = null;
    public $OriginalRecipient = null;
    public $Subject = null;
    public $MessageID = null;
    public $ReplyTo = null;
    public $MailboxHash = null;
    public $Date = null;
    public $TextBody = null;
    public $HtmlBody = null;
    public $StrippedTextReply = null;
    public $Tag = null;
    public $Attachments = [];
    public $Headers = [];
}
