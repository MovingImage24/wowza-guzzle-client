<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model\Dvr;


interface Dvr
{
    /**
     * @return string
     */
    public function getRecordingname();

    /**
     * @param string $recordingname
     */
    public function setRecordingname($recordingname);
}