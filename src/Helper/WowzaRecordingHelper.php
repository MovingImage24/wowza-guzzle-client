<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording\WowzaRecording;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class WowzaRecordingHelper extends AbstractWowzaHelper
{

    /**
     * @param string     $method
     * @param Config     $wowzaConfig
     * @param WowzaModel $recording
     * @param string     $suffix
     *
     * @return string
     */
    public function buildUrl($method, Config $wowzaConfig, WowzaModel $recording, $suffix = '')
    {
        //TODO: Watt is, wenn die ApiUrl anders als erwartet eingetragen wurde
        /**@var WowzaRecording $recording */
        return $wowzaConfig->getApiUrl() .
        '/' . $method .
        '?app=' . $wowzaConfig->getApp() .
        '&streamname=' . $recording->getStreamname() .
        '&action=' . $recording->getAction() .
        '&fileTemplate=' . $suffix . '_${SourceStreamName}';
    }
}
