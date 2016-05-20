<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Response;
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
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
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
            $result = new Response(404, [], 'Something went wrong');
            if ($e instanceof ConnectException) {
                $result = new Response(400, [], $e->getMessage());
            }
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
     * @param WowzaModel $cuepoint
     *
     * @return array
     */
    abstract function parseResponse(Response $response, WowzaModel $cuepoint);
}
