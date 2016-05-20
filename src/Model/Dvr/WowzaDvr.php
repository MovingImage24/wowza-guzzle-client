<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model\Dvr;

use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 * @codeCoverageIgnore
 */
final class WowzaDvr extends WowzaModel implements Dvr
{
    private $streamname;
    private $recordingname;
    private $action;

    /**
     * @return mixed
     */
    public function getStreamname()
    {
        return $this->streamname;
    }

    /**
     * @param mixed $streamname
     */
    public function setStreamname($streamname)
    {
        $this->streamname = $streamname;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getRecordingname()
    {
        return $this->recordingname;
    }

    /**
     * @param string $recordingname
     */
    public function setRecordingname($recordingname)
    {
        $this->recordingname = $recordingname;
    }

}
