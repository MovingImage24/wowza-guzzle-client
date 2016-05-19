<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaDvrHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class WowzaDvrHandler extends WowzaApiClient implements DvrHandler
{
    /**@var WowzaDvrHelper $dvrHelper */
    private $dvrHelper;
    private $data = [];

    /**
     * DvrHandler constructor.
     *
     * @param WowzaConfig    $wowzaConfig
     * @param Client         $client
     * @param WowzaDvrHelper $dvrHelper
     */
    public function __construct(WowzaConfig $wowzaConfig, Client $client, WowzaDvrHelper $dvrHelper)
    {
        parent::__construct($wowzaConfig, $client);

        $this->dvrHelper = $dvrHelper;
    }

    /**
     * @param string $streamname
     * @param string $recordingname
     *
     * @return JsonResponse
     */
    public function startDvr($streamname, $recordingname)
    {
        $this->data['action'] = 'start';

        return $this->dvrTask($streamname, $recordingname);
    }

    /**
     * @param string $streamname
     * @param string $recordingname
     *
     * @return JsonResponse
     */
    public function stopDvr($streamname, $recordingname)
    {
        $this->data['action'] = 'stop';

        return $this->dvrTask($streamname, $recordingname);
    }

    /**
     * @param string $streamname
     * @param string $recordingname
     *
     * @return JsonResponse
     */
    private function dvrTask($streamname, $recordingname)
    {
        $this->data['streamname']    = $streamname;
        $this->data['recordingname'] = $recordingname;

        $url            = $this->dvrHelper->buildUrl('dvrstreamrecord', $this->wowzaConfig, $this->data);
        $result         = $this->dvrHelper->call($this->wowzaConfig, $url, $this->client);
        $parsedResponse = $this->dvrHelper->parseResponse($result, $this->data);

        return new JsonResponse($parsedResponse, $parsedResponse['code']);
    }
}
