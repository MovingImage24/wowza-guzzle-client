<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
final class WowzaCuepoint extends WowzaConfig
{
    private $streamname;
    private $action;
    private $text;

    /**
     * WowzaConfig constructor.
     *
     * @param array $wowzaConfig
     */
    public function __construct(array $wowzaConfig)
    {
        parent::__construct($wowzaConfig);
    }

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
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

}
