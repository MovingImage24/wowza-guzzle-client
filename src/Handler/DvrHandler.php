<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\DvrHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class DvrHandler extends WowzaApiClient
{
    /**@var DvrHelper $dvrHelper */
    private $dvrHelper;
    private $data = [];

    /**
     * DvrHandler constructor.
     *
     * @param array     $wowzaConfig
     * @param Client    $client
     * @param DvrHelper $dvrHelper
     */
    public function __construct(array $wowzaConfig, Client $client, DvrHelper $dvrHelper)
    {
        parent::__construct($wowzaConfig, $client);

        $this->dvrHelper = $dvrHelper;
        $this->data      = [
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

        $url            = $this->dvrHelper->buildUrl('dvrstreamrecord', $this->data);
        $result         = $this->dvrHelper->call($this->data, $url, $this->client);
        $parsedResponse = $this->dvrHelper->parseResponse($result, $this->data);

        return new JsonResponse($parsedResponse, $parsedResponse['code']);
    }
}
