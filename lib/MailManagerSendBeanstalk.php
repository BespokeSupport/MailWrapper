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

use Pheanstalk\Pheanstalk;

/**
 * Class MailManagerSendBeanstalk
 * @package BespokeSupport\MailWrapper
 */
class MailManagerSendBeanstalk
{
    /**
     * @param Pheanstalk $transport
     * @param null $tube
     * @param MailWrappedMessage|null $message
     * @return int
     * @throws MailWrapperSendException
     * @throws MailWrapperSetupException
     */
    public static function store(Pheanstalk $transport, $tube = null, MailWrappedMessage $message = null)
    {
        if (!$message || !($message instanceof MailWrappedMessage)) {
            throw new MailWrapperSetupException('No Message');
        }

        if (!is_string($tube)) {
            throw new MailWrapperSetupException('No Tube');
        }

        try {
            $storageId = $transport->putInTube(
                $tube,
                $message
            );
            return $storageId;
        } catch (\Exception $exception) {
            throw new MailWrapperSendException('Message store failure');
        }
    }

    public static function send(Pheanstalk $transport, $tube)
    {

    }
}
