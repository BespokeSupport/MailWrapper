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

use BespokeSupport\MailWrapper\MessageTransformer;

/**
 * Class MessageConvertTest
 * @package BespokeSupport\MailWrapper\Tests
 */
class MessageConvertTest extends MailWrapperTestBootstrap
{
    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNoConverterMailgun()
    {
        MessageTransformer::convert('mailgun', null);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNoConverterSwift()
    {
        MessageTransformer::convert('swift', null);
    }

    /**
     * @expectedException \BespokeSupport\MailWrapper\MailWrapperSetupException
     */
    public function testNoConverterZend()
    {
        MessageTransformer::convert('zend', null);
    }
}
