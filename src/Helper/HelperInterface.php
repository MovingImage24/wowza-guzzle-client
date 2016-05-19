<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
interface HelperInterface
{
    /**
     * @param WowzaConfig $wowzaConfig
     * @param string $url
     * @param Client $client
     *
     * @return mixed
     */
    public function call(WowzaConfig $wowzaConfig, $url, Client $client);
}