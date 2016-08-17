<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiConnectException;
use Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;
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
     * @throws MiConnectException
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
            if ($e instanceof ConnectException) {
                throw new MiConnectException($e->getMessage());
            }

            throw new MiException();
        }

        return $result;
    }

    /**
     * @param string     $method
     * @param Config     $wowzaConfig
     * @param WowzaModel $cuepoint
     *
     * @return string
     */
    abstract function buildUrl($method, Config $wowzaConfig, WowzaModel $cuepoint);
}
