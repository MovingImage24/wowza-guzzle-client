<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Psr7\Response;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class CuepointHelper extends AbstractHelper
{
    /**
     * @param string $method
     * @param array  $data
     *
     * @return string
     */
    public function buildUrl($method, array $data)
    {
        return $data['wowzaProtocol'] . '://' .
        $data['wowzaHostname'] . ':' .
        $data['wowzaDvrPort'] .
        '/' . $method .
        '?app=' . $data['wowzaApp'] .
        '&streamname=' . $data['streamname'] .
        '&text=' . $data['text'];
    }

    /**
     * @param Response $response
     * @param array    $data
     *
     * @return array
     */
    public function parseResponse(Response $response, array $data)
    {
        if (preg_match('/.* is requirde/', $response->getBody()) ||
            preg_match('/.* not found/', $response->getBody()) ||
            $response->getStatusCode() === 400
        ) {
            return [
                'code'    => 400,
                'message' => 'Bad Request'
            ];
        }

        if ($response->getStatusCode() === 404) {
            return [
                'code'    => 404,
                'message' => 'Something went wrong'
            ];
        }

        $timestamp     = '';
        $responseArray = explode(':', $response->getBody());
        if (isset($responseArray) && count($responseArray)) {
            $timestamp = array_pop($responseArray);
        }

        return [
            'code'      => 200,
            'message'   => $data['text'],
            'timestamp' => $timestamp
        ];
    }
}
