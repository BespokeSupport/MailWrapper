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

    /**
     * @param string $endpointUrl
     * @param array $queryString
     * @return \stdClass
     */
    public function get($endpointUrl, $queryString = array())
    {
        $url = $this->domain . $endpointUrl;
        return parent::get($url, $queryString);
    }

    /**
     * @param string $endpointUrl
     * @param array $queryString
     * @param array $files
     * @return \stdClass
     */
    public function post($endpointUrl, $queryString = array(), $files = array())
    {
        $url = $this->domain . $endpointUrl;
        return parent::post($url, $queryString, $files);
    }

    /**
     * @param string $endpointUrl
     * @param array $queryString
     * @return \stdClass
     */
    public function put($endpointUrl, $queryString = array())
    {
        $url = $this->domain . $endpointUrl;
        return parent::put($url, $queryString);
    }

    /**
     * @param string $endpointUrl
     * @param array $queryString
     * @return \stdClass
     */
    public function delete($endpointUrl, $queryString = array())
    {
        $url = $this->domain . $endpointUrl;
        return parent::delete($url);
    }
}
