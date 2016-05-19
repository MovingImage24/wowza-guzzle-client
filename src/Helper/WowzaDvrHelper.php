<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class WowzaDvrHelper extends AbstractWowzaHelper
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
        '&recordingname=' . $data['recordingname'] .
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
        if (preg_match('/Live stream .* does not exist/', $response->getBody())) {
            return [
                'code'    => 404,
                'message' => $data['streamname'] . ' does not exist'
            ];
        }

        if ($response->getStatusCode() === 401) {
            return [
                'code'    => 401,
                'message' => 'Bad credentials'
            ];
        }

        $split = explode(' ', $response->getBody());

        return [
            'code'    => 200,
            'message' => [
                'action'        => $data['action'] . '_dvr',
                'recordingName' => array_pop($split)
            ]
        ];
    }
}
