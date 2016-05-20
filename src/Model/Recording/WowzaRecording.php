<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording;

use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
final class WowzaRecording extends WowzaModel implements Recording
{
    private $streamname;
    private $action;
    private $option;

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
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @param string $option
     */
    public function setOption($option)
    {
        $this->option = $option;
    }

}
