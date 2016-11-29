<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class WowzaApiClient
{
    const OPTION_VERSION = 'version';
    const OPTION_APPEND = 'append';
    const OPTION_OVERWRITE = 'overwrite';

    protected $wowzaConfig;
    protected $client;

    /**
     * WowzaApiClient constructor.
     *
     * @param Client      $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Config
     */
    public function getWowzaConfig()
    {
        return $this->wowzaConfig;
    }

    /**
     * @param Config $wowzaConfig
     */
    public function setWowzaConfig($wowzaConfig)
    {
        $this->wowzaConfig = $wowzaConfig;
    }

    /**
     * @param Config $wowzaConfig
     * @return Integer
     */
    public function checkWowzaConfig(Config $wowzaConfig) {
        $url = $wowzaConfig->getApiUrl() .
            '/livesetmetadata';
        $request = $this->client->createRequest(
            'GET',
            $url,
            [
                'auth' => [$wowzaConfig->getUsername(), $wowzaConfig->getPassword(), 'Digest'],
                'query' => ['app' => $wowzaConfig->getApp()]
            ]
        );

        try {
            $result = $this->client->send($request);

            return $result->getStatusCode();
        } catch (RequestException $e) {
            return $e->getResponse()->getStatusCode();
        }
    }
}
