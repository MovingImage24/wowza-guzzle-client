<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint;


interface Cuepoint
{
    /**
     * @return string
     */
    public function getText();

    /**
     * @param string $text
     */
    public function setText($text);
}