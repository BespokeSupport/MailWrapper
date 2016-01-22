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
class ExceptionTest extends MailWrapperTestBootstrap
{
    /**
     *
     */
    public function testMailable()
    {
        try {
            throw (new MailWrapperMailableException)->setParams([
                'test1' => 'test2',
                'test3' => 'test4',
            ]);
        } catch (MailWrapperMailableException $e) {
            $this->assertCount(2, $e->getParams());
        }
    }

    /**
     *
     */
    public function testMailableNull()
    {
        try {
            throw (new MailWrapperMailableException)->setParams(null);
        } catch (MailWrapperMailableException $e) {
            $this->assertCount(0, $e->getParams());
        }
    }

    /**
     *
     */
    public function testSendMailableException()
    {
        if (!class_exists('Swift_NullTransport')) {
            return;
        }

        $transport = new \Swift_NullTransport();

        $e = (new MailWrapperMailableException)->setParams(['test1' => 'test2']);
        MailManager::sendExceptionTo(
            $transport,
            'hello@example.com',
            'hello@example.com',
            $e,
            'hello@example.com'
        );
    }
}
