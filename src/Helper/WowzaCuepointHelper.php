<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint\WowzaCuepoint;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class WowzaCuepointHelper extends AbstractWowzaHelper
{
    /**
     * @param string      $method
     * @param WowzaConfig $wowzaConfig
     * @param WowzaModel  $cuepoint
     *
     * @return string
     */
    public function buildUrl($method, WowzaConfig $wowzaConfig, WowzaModel $cuepoint)
    {
        /**@var WowzaCuepoint $cuepoint */
        return $wowzaConfig->getWowzaProtocol() . '://' .
        $wowzaConfig->getWowzaHostname() . ':' .
        $wowzaConfig->getWowzaDvrPort() .
        '/' . $method .
        '?app=' . $wowzaConfig->getWowzaApp() .
        '&streamname=' . $cuepoint->getStreamname() .
        '&text=' . $cuepoint->getText();
    }

    /**
     * @param Response   $response
     * @param WowzaModel $cuepoint
     *
     * @return array
     */
    public function parseResponse(Response $response, WowzaModel $cuepoint)
    {

        if (preg_match('/.* is required/', $response->getBody()) ||
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
            'message'   => $cuepoint->getText(),
            'timestamp' => $timestamp
        ];
    }
}
