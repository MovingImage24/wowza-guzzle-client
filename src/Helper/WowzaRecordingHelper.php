<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper;

use Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording\WowzaRecording;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class WowzaRecordingHelper extends AbstractWowzaHelper
{
    /**
     * @inheritdoc
     */
    public function buildUrl($method, $wowzaConfig, WowzaModel $recording, $prefix)
    {
        /**@var WowzaRecording $recording */
        return $wowzaConfig->getApiUrl().
            '/'.$method.
            '?app='.$wowzaConfig->getApp().
            '&streamname='.$recording->getStreamname().
            '&option='.$recording->getOption().
            '&action='.$recording->getAction().
            '&outputFile='.$prefix.'_'.$recording->getStreamname().'.mp4';
    }
}
