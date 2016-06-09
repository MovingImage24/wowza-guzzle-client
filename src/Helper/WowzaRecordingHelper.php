<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording\WowzaRecording;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class WowzaRecordingHelper extends AbstractWowzaHelper
{


    /**
     * @param string      $method
     * @param WowzaConfig $wowzaConfig
     * @param WowzaModel  $recording
     *
     * @return string
     */
    public function buildUrl($method, WowzaConfig $wowzaConfig, WowzaModel $recording)
    {
        /**@var WowzaRecording $recording */
        return $wowzaConfig->getWowzaProtocol() . '://' .
        $wowzaConfig->getWowzaHostname() . ':' .
        $wowzaConfig->getWowzaDvrPort() .
        '/' . $method .
        '?app=' . $wowzaConfig->getWowzaApp() .
        '&streamname=' . $recording->getStreamname() .
        '&action=' . $recording->getAction();
    }

    /**
     * @param Response   $response
     * @param WowzaModel $recording
     *
     * @return array
     */
    public function parseResponse(Response $response, WowzaModel $recording)
    {
        /**@var WowzaRecording $recording */
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
            'message' => $recording->getAction()
        ];
    }
}
