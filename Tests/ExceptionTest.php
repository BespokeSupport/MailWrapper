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
use BespokeSupport\MailWrapper\MailWrapperMailableException;

/**
 * Class ExceptionTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testMailable()
    {
        try {
            throw (new MailWrapperMailableException)->setParams(['test1' => 'test2']);
        } catch (MailWrapperMailableException $e) {
            $this->assertCount(1, $e->getParams());
        }
    }

    public function testMailableNull()
    {
        try {
            throw (new MailWrapperMailableException)->setParams(null);
        } catch (MailWrapperMailableException $e) {
            $this->assertCount(0, $e->getParams());
        }
    }

    public function testSendMailableException()
    {
        $e = (new MailWrapperMailableException)->setParams(['test1' => 'test2']);
        $transport = new \Swift_NullTransport();
        MailManager::sendExceptionTo(
            $transport,
            'hello@example.com',
            'hello@example.com',
            $e,
            'hello@example.com'
        );
    }


}
