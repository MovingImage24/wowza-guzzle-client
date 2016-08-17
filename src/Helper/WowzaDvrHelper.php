<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use Mi\Bundle\WowzaGuzzleClientBundle\Model\Dvr\WowzaDvr;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class WowzaDvrHelper extends AbstractWowzaHelper
{
    /**
     * @param string     $method
     * @param Config     $wowzaConfig
     * @param WowzaModel $dvr
     *
     * @return string
     */
    public function buildUrl($method, Config $wowzaConfig, WowzaModel $dvr)
    {
        //TODO: Watt is, wenn die ApiUrl anders als erwartet eingetragen wurde
        /**@var WowzaDvr $dvr */
        return $wowzaConfig->getApiUrl() .
        '/' . $method .
        '?app=' . $wowzaConfig->getApp() .
        '&streamname=' . $dvr->getStreamname() .
        '&recordingname=' . $dvr->getRecordingname() .
        '&action=' . $dvr->getAction();
    }
}
