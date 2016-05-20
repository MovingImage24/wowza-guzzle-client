<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording;


interface Recording
{
    /**
     * @return string
     */
    public function getAction();

    /**
     * @param string $action
     */
    public function setAction($action);
}