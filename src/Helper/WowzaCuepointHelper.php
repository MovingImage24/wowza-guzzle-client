<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint\Response as ResponseCupoint;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint\WowzaCuepoint;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class WowzaCuepointHelper extends AbstractWowzaHelper
{
    /**
     * @inheritdoc
     */
    public function buildUrl($method, $wowzaConfig, WowzaModel $cuepoint, $prefix = '')
    {
        //TODO: Watt is, wenn die ApiUrl anders als erwartet eingetragen wurde
        /**@var WowzaCuepoint $cuepoint */
        return $wowzaConfig->getApiUrl().
            '/'.$method.
            '?app='.$wowzaConfig->getApp().
            '&streamname='.$cuepoint->getStreamname().
            '&text='.urlencode($cuepoint->getText());
    }

    /**
     * @param Response $response
     *
     * @return ResponseCupoint
     * @throws MiException
     */
    public function getCuepointResponse(Response $response): ResponseCupoint
    {
        if (preg_match('/.* is required/', $response->getBody()) ||
            preg_match('/.* not found/', $response->getBody())
        ) {
            throw new MiException(
                'Something is wrong with the response of Wowza server: [body] '. $response->getBody()
            );
        }

        $timestamp = '';
        $responseArray = explode(':', $response->getBody());
        if (isset($responseArray) && count($responseArray)) {
            $timestamp = array_pop($responseArray);
        }

        return new ResponseCupoint($timestamp,  $response->getBody());
    }
}
