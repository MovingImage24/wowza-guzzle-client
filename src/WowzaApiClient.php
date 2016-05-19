<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle;

use GuzzleHttp\Client;
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
     * @param WowzaConfig $wowzaConfig
     * @param Client      $client
     */
    public function __construct(WowzaConfig $wowzaConfig, Client $client)
    {
        $this->wowzaConfig        = $wowzaConfig;
        $this->client             = $client;
    }
}
