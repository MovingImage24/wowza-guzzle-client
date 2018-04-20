<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaRecordingHelper;
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
     * @param Client               $client
     * @param WowzaRecordingHelper $recordingHelper
     * @param WowzaRecording       $recording
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
    public function startRecording($streamName, $option = self::OPTION_VERSION, $prefix = '')
    {
        $this->recording->setAction('startRecording');

        return $this->recordingTask($streamName, $option, $prefix);
    }

    /**
     * @inheritDoc
     * @throws \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stopRecording($streamName, $prefix = '')
    {
        $this->recording->setAction('stopRecording');

        return $this->recordingTask($streamName, null, $prefix);
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
    public function setConfig($config)
    {
        parent::setWowzaConfig($config);
    }

    /**
     * @param string $streamName
     * @param string $option
     *
     * @param string $prefix
     *
     * @throws \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function recordingTask($streamName, $option = null, $prefix = '')
    {
        $this->recording->setStreamname($streamName);
        $this->recording->setOption($option);

        $url = $this->recordingHelper->buildUrl('livestreamrecord', $this->wowzaConfig, $this->recording, $prefix);
        $this->recordingHelper->call($this->wowzaConfig, $url, $this->client);
    }
}
