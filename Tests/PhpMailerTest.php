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

/**
 * Class PhpMailerTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class PhpMailerTest extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $transport = new EntityPhpMailerTrue(true);

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
        $transport = new EntityPhpMailerException(true);

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
        $transport = new EntityPhpMailerTrue(true);

        MailManager::send($transport);
    }
}
