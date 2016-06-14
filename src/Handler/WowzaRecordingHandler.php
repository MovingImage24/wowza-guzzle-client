<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaRecordingHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording\WowzaRecording;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
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
    /** @var  Response */
    private $recordingResponse;

    /**
     * @param WowzaConfig          $wowzaConfig
     * @param Client               $client
     * @param WowzaRecordingHelper $recordingHelper
     * @param WowzaRecording       $recording
     * @param Response       $recordingResponse
     */
    public function __construct(
        WowzaConfig $wowzaConfig,
        Client $client,
        WowzaRecordingHelper $recordingHelper,
        WowzaRecording $recording,
        Response $recordingResponse
    )
    {
        parent::__construct($wowzaConfig, $client);

        $this->recordingHelper   = $recordingHelper;
        $this->recording         = $recording;
        $this->recordingResponse = $recordingResponse;
    }

    /**
     * @param string $streamname
     * @param string $option
     *
     * @return JsonResponse
     */
    public function startRecording($streamname, $option = 'append')
    {
        $this->recording->setAction('startRecording');

        return $this->recordingTask($streamname, $option);
    }

    /**
     * @param string $streamname
     * @param string $option
     *
     * @return JsonResponse
     */
    public function stopRecording($streamname, $option = 'append')
    {
        $this->recording->setAction('stopRecording');

        return $this->recordingTask($streamname, $option);
    }

    /**
     * @param string $streamname
     * @param string $option
     *
     * @return Response
     */
    private function recordingTask($streamname, $option)
    {
        $this->recording->setStreamname($streamname);
        $this->recording->setOption($option);

        $url            = $this->recordingHelper->buildUrl('livestreamrecord', $this->wowzaConfig, $this->recording);
        $result         = $this->recordingHelper->call($this->wowzaConfig, $url, $this->client);
        $parsedResponse = $this->recordingHelper->parseResponse($result);
        $this->recordingResponse->setSuccess($parsedResponse);
        return $this->recordingResponse;
    }
}
