<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint;

use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaModel;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
final class WowzaCuepoint extends WowzaModel implements Cuepoint
{
    private $streamname;
    private $action;
    private $text;

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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

}
