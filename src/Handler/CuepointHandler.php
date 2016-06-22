<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
interface CuepointHandler
{
    /**
     * @param string $streamname
     * @param string $text
     *
     * @return JsonResponse
     */
    public function insertCuepoint($streamname, $text);


    /**
     * @return Config
     */
    public function getConfig();

    /**
     * @param Config $config
     */
    public function setConfig($config);
}
