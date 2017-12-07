<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
abstract class AbstractWowzaHelper
{
    /**
     * @param Config $wowzaConfig
     * @param string $url
     * @param Client $client
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws MiException
     */
    public function call(Config $wowzaConfig, $url, Client $client)
    {
        try {
            $request = $client->createRequest(
                'GET',
                $url,
                [
                    'auth' => [$wowzaConfig->getUsername(), $wowzaConfig->getPassword(), 'Digest']
                ]
            );

            $result = $client->send($request);
        } catch (\Exception $e) {
            throw new MiException($e->getMessage());
        }

        return $result;
    }

    /**
     * @param string $method
     * @param WowzaConfig $wowzaConfig
     * @param WowzaModel $cuepoint
     *
     * @param $prefix
     * @return string
     */
    abstract function buildUrl($method, $wowzaConfig, WowzaModel $cuepoint, $prefix);
}
