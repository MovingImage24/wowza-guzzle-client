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
    public function startRecording(
        string $streamName,
        string $option = WowzaApiClient::OPTION_OVERWRITE,
        string $prefix = ''
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
