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

namespace BespokeSupport\MailWrapper\Tests\Send;

use BespokeSupport\MailWrapper\MailManager;
use BespokeSupport\MailWrapper\MailManagerSendZend;
use BespokeSupport\MailWrapper\Tests\MailWrapperTestBootstrap;
use Zend\Mail\Message;
use Zend\Mail\Transport\InMemory;

/**
 * Class ZendTest
 * @package BespokeSupport\MailWrapper\Tests\Send
 */
class ZendTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function setUp()
    {
        if (!class_exists('Zend\Mail\Message')) {
            $this->markTestSkipped('Zend\Mail\Message not installed');
        }
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testException()
    {
        $transport = new InMemory();
        $message = null;

        MailManagerSendZend::send($transport, $message);
    }

    /**
     *
     */
    public function testSendVia()
    {
        $transport = new InMemory();
        $message = new Message();

        MailManagerSendZend::send($transport, $message);
    }

    /**
     *
     */
    public function testSend()
    {
        $transport = new InMemory();
        $message = new Message();

        MailManager::send($message, $transport);
    }
}
