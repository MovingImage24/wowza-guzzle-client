<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Response;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
abstract class AbstractWowzaHelper
{
    /**
     * @param array  $data
     * @param string $url
     * @param Client $client
     *
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     */
    public function call(array $data, $url, Client $client)
    {
        try {
            $result = $client->request(
                'GET',
                $url,
                [
                    'auth' => [$data['wowzaAdmin'], $data['wowzaAdminPassword'], 'Digest']
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
     * @param string $method
     * @param array  $data
     *
     * @return string
     */
    abstract function buildUrl($method, array $data);

    /**
     * @param Response $response
     * @param array    $data
     *
     * @return array
     */
    abstract function parseResponse(Response $response, array $data);
}
