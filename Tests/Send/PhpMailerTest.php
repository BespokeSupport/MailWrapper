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
use BespokeSupport\MailWrapper\MailManagerSendPhpMailer;
use BespokeSupport\MailWrapper\MessageTransformerPhpMailer;
use BespokeSupport\MailWrapper\TesterMessage\TesterMessagePhpMailer;
use BespokeSupport\MailWrapper\TesterMessage\TesterWrappedMessage;
use BespokeSupport\MailWrapper\TesterTransport\TesterTransportPhpMailerException;
use BespokeSupport\MailWrapper\TesterTransport\TesterTransportPhpMailerNull;
use BespokeSupport\MailWrapper\Tests\MailWrapperTestBootstrap;

/**
 * Class PhpMailerTest
 * @package BespokeSupport\MailWrapper\Tests\Send
 */
class PhpMailerTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function setUp()
    {
        if (!class_exists('PHPMailer')) {
            $this->markTestSkipped('PHPMailer not installed');
        }
    }

    /**
     *
     */
    public function testSend()
    {
        $transport = new TesterTransportPhpMailerNull(true);
        $transport->setFrom('from@example.com');
        $transport->addAddress('hello@example.com');
        $transport->Body = 'hello2';
        $transport->isSMTP();
        $transport->Host = 'example.com';
        $transport->SMTPAuth = true;
        $transport->Username = 'TEST';
        $transport->Password = 'TEST';

        MailManager::send($transport);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testSendFailPreAuth()
    {
        $transport = new TesterTransportPhpMailerNull(true);
        $transport->From = 'INVALID'; // exception
        $transport->addAddress('hello@example.com');
        $transport->Body = 'hello2';
        $transport->isSMTP();
        $transport->Host = 'example.com';
        $transport->SMTPAuth = true;
        $transport->Username = 'TEST';
        $transport->Password = 'TEST';

        MailManager::send($transport);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSendException
     */
    public function testSendException()
    {
        $transport = new TesterTransportPhpMailerException(true);

        $transport->addAddress('hello@example.com');
        $transport->Body = 'hello2';
        $transport->isSMTP();
        $transport->Host = 'example.com';
        $transport->SMTPAuth = true;
        $transport->Username = 'TEST';
        $transport->Password = 'TEST';

        MailManager::send($transport);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testSendExceptionSetup()
    {
        $transport = new TesterTransportPhpMailerNull(true);
        MailManager::send($transport);
    }

    /**
     *
     */
    public function testSendMerge()
    {
        $message = TesterWrappedMessage::getValid();
        $transport = new TesterTransportPhpMailerNull(true);
        MailManagerSendPhpMailer::send($transport, $message);
    }

    /**
     *
     */
    public function testSendMergeSelf()
    {
        $mailer = TesterMessagePhpMailer::getValid();
        MessageTransformerPhpMailer::merge($mailer, $mailer);
    }
}
