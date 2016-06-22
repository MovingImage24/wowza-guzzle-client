<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
interface DvrHandler
{
    /**
     * @param string $streamname
     * @param string $recordingname
     *
     * @return JsonResponse
     */
    public function startDvr($streamname, $recordingname);

    /**
     * @param string $streamname
     * @param string $recordingname
     *
     * @return JsonResponse
     */
    public function stopDvr($streamname, $recordingname);

    /**
     * @return Config
     */
    public function getConfig();

    /**
     * @param Config $config
     */
    public function setConfig($config);
}
