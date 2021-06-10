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
     * @param string $prefix
     * @param string $option
     */
    public function startRecording(
        string $streamName,
        string $prefix,
        string $option = WowzaApiClient::OPTION_OVERWRITE
    ): void;

    /**
     * @param string $streamName
     * @param string $prefix
     */
    public function stopRecording(string $streamName, string $prefix): void;

    /**
     * @return Config
     */
    public function getConfig();

    /**
     * @param Config $config
     */
    public function setConfig(Config $config);
}
