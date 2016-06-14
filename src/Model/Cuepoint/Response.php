<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 * @author Volker Bredow <volker.bredow@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class Response
{
    /** @var  int */
    private $timestamp;

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }


}
