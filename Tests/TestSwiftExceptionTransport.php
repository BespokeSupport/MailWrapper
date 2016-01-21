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

namespace BespokeSupport\MailWrapper\Tests;

use Swift_Mime_Message;

/**
 * Class TestSwiftExceptionTransport
 */
class TestSwiftExceptionTransport implements \Swift_Transport
{
    /**
     * Tests if this Transport mechanism has started.
     *
     * @return bool
     */
    public function isStarted()
    {
        return true;
    }

    /**
     * Starts this Transport mechanism.
     */
    public function start()
    {
    }

    /**
     * Stops this Transport mechanism.
     */
    public function stop()
    {
    }

    /**
     * @param Swift_Mime_Message $message
     * @param null $failedRecipients
     * @return int|void
     * @throws \Swift_TransportException
     */
    public function send(\Swift_Mime_Message $message, &$failedRecipients = null)
    {
        if ($message) {
        }
        if ($failedRecipients) {
        }
        throw new \Swift_TransportException('TEST');
    }

    /**
     * @param \Swift_Events_EventListener $listener
     */
    public function registerPlugin(\Swift_Events_EventListener $listener)
    {
        if ($listener) {
        }
    }
}
