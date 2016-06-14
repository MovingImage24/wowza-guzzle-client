<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model\Dvr;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 * @author Volker Bredow <volker.bredow@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class Response
{
    /** @var  string */
    private $recordingName;

    /**
     * @return string
     */
    public function getRecordingName()
    {
        return $this->recordingName;
    }

    /**
     * @param string $recordingName
     */
    public function setRecordingName($recordingName)
    {
        $this->recordingName = $recordingName;
    }
}
