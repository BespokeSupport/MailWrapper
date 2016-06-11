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

/**
 * Class MailWrapperMailableException
 * @package BespokeSupport\MailWrapper
 */
class MailWrapperMailableException extends MailWrapperException
{
    protected $params = [];

    /**
     * @return array
     */
    public function __sleep()
    {
        return [
            'params',
            'message',
            'code',
            'file',
            'line',
        ];
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Pass GET POST etc Params
     */
    public function setParams()
    {
        $args = func_get_args();

        $args = array_reverse($args);

        foreach ($args as $arg) {
            if (!is_array($arg)) {
                continue;
            }

            $this->params = array_merge(
                $this->params,
                $arg
            );
        }

        return $this;
    }
}
