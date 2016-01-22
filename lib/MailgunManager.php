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

use Mailgun\Mailgun;

/**
 * Class MailgunManager
 * @package BespokeSupport\MailWrapper
 */
class MailgunManager extends Mailgun
{
    /**
     * @var string
     */
    protected $domain;

    /**
     * MailgunManager constructor.
     * @param string $apiKey
     * @param string $domain
     * @throws MailWrapperSetupException
     */
    public function __construct($apiKey, $domain)
    {
        if (!$apiKey || !$domain) {
            throw new MailWrapperSetupException('API Key and Domain must be provided');
        }
        $this->domain = $domain;
        $this->apiKey = $apiKey;
        parent::__construct($apiKey);
    }

    /**
     * @return MailgunMessage
     */
    public function batch()
    {
        return new MailgunMessage($this->restClient, $this->domain, false);
    }

    /**
     * @param $apiKey
     * @param $domain
     * @return MailgunManager
     */
    public static function newInstance($apiKey, $domain)
    {
        return new self($apiKey, $domain);
    }
}
