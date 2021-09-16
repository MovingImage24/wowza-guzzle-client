<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle;

use GuzzleHttp\ClientInterface;
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
    const CONNECTION_TIMEOUT = 5;

    protected $wowzaConfig;
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getWowzaConfig(): Config
    {
        return $this->wowzaConfig;
    }

    public function setWowzaConfig($wowzaConfig): void
    {
        $this->wowzaConfig = $wowzaConfig;
    }

    public function checkWowzaConfig(Config $wowzaConfig, int $timeout = self::CONNECTION_TIMEOUT): int
    {
        $url = $wowzaConfig->getApiUrl() . '/livesetmetadata';


        try {
            $result = $this->client->request(
                'GET',
                $url,
                [
                    'auth' => [$wowzaConfig->getUsername(), $wowzaConfig->getPassword(), 'Digest'],
                    'query' => ['app' => $wowzaConfig->getApp()],
                    'connect_timeout' => $timeout
                ]
            );

            return $result->getStatusCode();
        } catch (RequestException $e) {
            return $e->getResponse()->getStatusCode();
        }
    }
}
