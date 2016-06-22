<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class WowzaApiClient
{
    protected $wowzaConfig;
    protected $client;

    /**
     * WowzaApiClient constructor.
     *
     * @param Client      $client
     */
    public function __construct(Client $client)
    {
        $this->client             = $client;
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
}
