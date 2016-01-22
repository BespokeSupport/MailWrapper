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

use BespokeSupport\MailWrapper\MailManager;
use Zend\Mail\Message;
use Zend\Mail\Transport\InMemory;

/**
 * Class ZendTest
 * @package BespokeSupport\MailWrapper\Tests
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

        MailManager::sendViaZend($transport, $message);
    }

    /**
     *
     */
    public function testSendVia()
    {
        $transport = new InMemory();
        $message = new Message();

        MailManager::sendViaZend($transport, $message);
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
