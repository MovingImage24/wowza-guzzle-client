<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\RecordingHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class RecordingHandler extends WowzaApiClient
{
    /**@var RecordingHelper $recordingHelper */
    private $recordingHelper;
    private $data = [];

    /**
     * @param array           $wowzaConfig
     * @param Client          $client
     * @param RecordingHelper $recordingHelper
     */
    public function __construct(array $wowzaConfig, Client $client, RecordingHelper $recordingHelper)
    {
        parent::__construct($wowzaConfig, $client);

        $this->recordingHelper = $recordingHelper;
        $this->data            = [
            'wowzaAdmin'         => $this->wowzaAdmin,
            'wowzaAdminPassword' => $this->wowzaAdminPassword,
            'wowzaProtocol'      => $this->wowzaProtocol,
            'wowzaHostname'      => $this->wowzaHostname,
            'wowzaDvrPort'       => $this->wowzaDvrPort,
            'wowzaApp'           => $this->wowzaApp
        ];
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

        $url            = $this->recordingHelper->buildUrl('livestreamrecord', $this->data);
        $result         = $this->recordingHelper->call($this->data, $url, $this->client);
        $parsedResponse = $this->recordingHelper->parseResponse($result, $this->data);

        return new JsonResponse($parsedResponse, $parsedResponse['code']);
    }
}
