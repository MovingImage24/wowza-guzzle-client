<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaRecordingHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording\WowzaRecording;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function __construct(
        Client $client,
        WowzaRecordingHelper $recordingHelper,
        WowzaRecording $recording
    )
    {
        parent::__construct($client);

        $this->recordingHelper   = $recordingHelper;
        $this->recording         = $recording;
    }

    /**
     * @inheritDoc
     */
    public function startRecording($streamname, $option = 'append')
    {
        $this->recording->setAction('startRecording');

        return $this->recordingTask($streamname, $option);
    }

    /**
     * @inheritDoc
     */
    public function stopRecording($streamname, $option = 'append')
    {
        $this->recording->setAction('stopRecording');

        return $this->recordingTask($streamname, $option);
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
     * @param $streamname
     * @param $option
     *
     * @return bool
     * @throws \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiConnectException
     * @throws \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     */
    private function recordingTask($streamname, $option)
    {
        $this->recording->setStreamname($streamname);
        $this->recording->setOption($option);

        $url = $this->recordingHelper->buildUrl('livestreamrecord', $this->wowzaConfig, $this->recording);
        $this->recordingHelper->call($this->wowzaConfig, $url, $this->client);

        return true;
    }
}
