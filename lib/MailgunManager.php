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

use GuzzleHttp\Client;
use \Http\Adapter\Guzzle6\Client as Guzzle6Client;
use \Http\Adapter\Guzzle5\Client as Guzzle5Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
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

        // fixes for Puli factory breakages
        $client = null;
        if (class_exists('\Http\Adapter\Guzzle6\Client')) {
            $guzzleClient = new Client();
            $client = new Guzzle6Client($guzzleClient);
        } else if (class_exists('\Http\Adapter\Guzzle5\Client')) {
            $guzzleClient = new Client();
            $factory = new GuzzleMessageFactory();
            $client = new Guzzle5Client($guzzleClient, $factory);
        }
        parent::__construct($apiKey, $client);
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
