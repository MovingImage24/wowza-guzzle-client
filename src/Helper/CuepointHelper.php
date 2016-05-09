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
        if ($response->getStatusCode() === 400) {
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
        return [
            'code'    => 200,
            'message' => $data['text']
        ];
    }
}
