<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
interface RecordingHandler
{
    /**
     * @param string $streamName
     * @param string $option
     * @param $prefix
     * @return JsonResponse
     */
    public function startRecording($streamName, $option = WowzaApiClient::OPTION_OVERWRITE, $prefix);

    /**
     * @param string $streamName
     * @param $prefix
     * @return JsonResponse
     */
    public function stopRecording($streamName, $prefix);

    /**
     * @return Config
     */
    public function getConfig();

    /**
     * @param Config $config
     */
    public function setConfig($config);
}
