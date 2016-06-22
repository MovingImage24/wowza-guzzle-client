<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
interface RecordingHandler
{
    /**
     * @param string $streamname
     * @param string $option
     *
     * @return JsonResponse
     */
    public function startRecording($streamname, $option = 'append');

    /**
     * @param string $streamname
     * @param string $option
     *
     * @return JsonResponse
     */
    public function stopRecording($streamname, $option = 'append');

    /**
     * @return Config
     */
    public function getConfig();

    /**
     * @param Config $config
     */
    public function setConfig($config);
}
