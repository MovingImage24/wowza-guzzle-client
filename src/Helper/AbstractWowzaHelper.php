<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiConnectException;
use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
abstract class AbstractWowzaHelper
{
    /**
     * @param WowzaConfig $wowzaConfig
     * @param string      $url
     * @param Client      $client
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws MiConnectException
     * @throws MiException
     */
    public function call(WowzaConfig $wowzaConfig, $url, Client $client)
    {
        try {
            $result = $client->request(
                'GET',
                $url,
                [
                    'auth' => [$wowzaConfig->getWowzaAdmin(), $wowzaConfig->getWowzaAdminPassword(), 'Digest']
                ]
            );
        } catch (\Exception $e) {
            if ($e instanceof ConnectException) {
                throw new MiConnectException();
            }

            throw new MiException();
        }

        return $result;
    }

    /**
     * @param string      $method
     * @param WowzaConfig $wowzaConfig
     * @param WowzaModel  $cuepoint
     *
     * @return string
     */
    abstract function buildUrl($method, WowzaConfig $wowzaConfig, WowzaModel $cuepoint);

    /**
     * @param Response   $response
     *
     * @return array
     */
    abstract function parseResponse(Response $response);
}
