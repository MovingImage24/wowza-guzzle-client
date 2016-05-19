<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class WowzaRecordingHelper extends AbstractWowzaHelper
{


    /**
     * @param string      $method
     * @param WowzaConfig $wowzaConfig
     * @param array       $data
     *
     * @return string
     */
    public function buildUrl($method, WowzaConfig $wowzaConfig, array $data)
    {
        return $wowzaConfig->getWowzaProtocol() . '://' .
        $wowzaConfig->getWowzaHostname() . ':' .
        $wowzaConfig->getWowzaDvrPort() .
        '/' . $method .
        '?app=' . $wowzaConfig->getWowzaApp() .
        '&streamname=' . $data['streamname'] .
        '&action=' . $data['action'];
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
            'message' => $data['action']
        ];
    }
}
