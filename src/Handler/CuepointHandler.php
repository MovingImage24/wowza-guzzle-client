<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint\Response;

/**
 * @codeCoverageIgnore
 */
interface CuepointHandler
{
    public function insertCuepoint($streamname, $text): Response;

    /**
     * @return Config
     */
    public function getConfig();

    /**
     * @param Config $config
     */
    public function setConfig($config);
}
