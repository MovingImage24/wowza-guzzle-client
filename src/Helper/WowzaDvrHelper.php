<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Dvr\WowzaDvr;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class WowzaDvrHelper extends AbstractWowzaHelper
{

    /**
     * @param string      $method
     * @param WowzaConfig $wowzaConfig
     * @param WowzaModel  $dvr
     *
     * @return string
     */
    public function buildUrl($method, WowzaConfig $wowzaConfig, WowzaModel $dvr)
    {
        /**@var WowzaDvr $dvr */
        return $wowzaConfig->getWowzaProtocol() . '://' .
        $wowzaConfig->getWowzaHostname() . ':' .
        $wowzaConfig->getWowzaDvrPort() .
        '/' . $method .
        '?app=' . $wowzaConfig->getWowzaApp() .
        '&streamname=' . $dvr->getStreamname() .
        '&recordingname=' . $dvr->getRecordingname() .
        '&action=' . $dvr->getAction();
    }

    /**
     * @param Response   $response
     * @param WowzaModel $dvr
     *
     * @return array
     */
    public function parseResponse(Response $response, WowzaModel $dvr)
    {
        /**@var WowzaDvr $dvr */
        if (preg_match('/Live stream .* does not exist/', $response->getBody())) {
            return [
                'code'    => 404,
                'message' => $dvr->getStreamname() . ' does not exist'
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
                'action'        => $dvr->getAction() . '_dvr',
                'recordingName' => array_pop($split)
            ]
        ];
    }
}
