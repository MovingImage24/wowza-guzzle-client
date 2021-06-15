<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaRecordingHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Config;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording\WowzaRecording;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class WowzaRecordingHandler extends WowzaApiClient implements RecordingHandler
{
    /**@var WowzaRecordingHelper $recordingHelper */
    private $recordingHelper;
    private $recording;

    /**
     * @param Client $client
     * @param WowzaRecordingHelper $recordingHelper
     * @param WowzaRecording $recording
     */
    public function __construct(Client $client, WowzaRecordingHelper $recordingHelper, WowzaRecording $recording)
    {
        parent::__construct($client);

        $this->recordingHelper = $recordingHelper;
        $this->recording = $recording;
    }

    /**
     * @inheritDoc
     * @throws \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function startRecording(
        string $streamName,
        string $option = WowzaApiClient::OPTION_OVERWRITE,
        string $prefix = ''
    ): void {
        $this->recording->setAction('startRecording');

        $this->recordingTask($streamName, $prefix, $option);
    }

    /**
     * @inheritDoc
     * @throws \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stopRecording(string $streamName, string $prefix = ''): void
    {
        $this->recording->setAction('stopRecording');

        $this->recordingTask($streamName, $prefix, null);
    }

    /**
     * @inheritDoc
     */
    public function getConfig()
    {
        parent::getWowzaConfig();
    }

    /**
     * @inheritDoc
     */
    public function setConfig(Config $config)
    {
        parent::setWowzaConfig($config);
    }

    /**
     * @param string $streamName
     * @param string $prefix
     * @param string|null $option
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     */
    private function recordingTask(string $streamName, string $prefix = '', string $option = null): void
    {
        $this->recording->setStreamname($streamName);
        $this->recording->setOption($option);

        $url = $this->recordingHelper->buildUrl('livestreamrecord', $this->wowzaConfig, $this->recording, $prefix);
        $this->recordingHelper->call($this->wowzaConfig, $url, $this->client);
    }
}
