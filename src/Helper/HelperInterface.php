<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Client;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
interface HelperInterface
{
    /**
     * @param array  $data
     * @param string $url
     * @param Client $client
     *
     * @return mixed
     */
    public function call(array $data, $url, Client $client);
}