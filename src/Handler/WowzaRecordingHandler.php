<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaRecordingHelper;
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
    private $data = [];

    /**
     * @param WowzaConfig          $wowzaConfig
     * @param Client               $client
     * @param WowzaRecordingHelper $recordingHelper
     */
    public function __construct(WowzaConfig $wowzaConfig, Client $client, WowzaRecordingHelper $recordingHelper)
    {
        parent::__construct($wowzaConfig, $client);

        $this->recordingHelper = $recordingHelper;
    }

    /**
     * @param string $streamname
     * @param string $option
     *
     * @return JsonResponse
     */
    public function startRecording($streamname, $option = 'append')
    {
        $this->data['action'] = 'startRecording';

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
        $this->data['action'] = 'stopRecording';

        return $this->recordingTask($streamname, $option);
    }

    /**
     * @param string $streamname
     * @param string $option
     *
     * @return JsonResponse
     */
    private function recordingTask($streamname, $option)
    {
        $this->data['streamname'] = $streamname;
        $this->data['option']     = $option;

        $url            = $this->recordingHelper->buildUrl('livestreamrecord', $this->wowzaConfig, $this->data);
        $result         = $this->recordingHelper->call($this->wowzaConfig, $url, $this->client);
        $parsedResponse = $this->recordingHelper->parseResponse($result, $this->data);

        return new JsonResponse($parsedResponse, $parsedResponse['code']);
    }
}
