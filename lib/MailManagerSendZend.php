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

use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

/**
 * Class MailManagerSendZend
 * @package BespokeSupport\MailWrapper
 */
class MailManagerSendZend
{

    /**
     * @param TransportInterface $transport
     * @param MailWrappedMessage|Message $message
     * @return mixed
     * @throws MailWrapperSetupException
     */
    public static function send(TransportInterface $transport, $message = null)
    {
        if (!($message instanceof Message)) {
            $message = MessageTransformerZend::fromWrappedMessage($message);
        }

        return $transport->send($message);
    }
}
