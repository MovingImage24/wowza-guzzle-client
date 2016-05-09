<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\CuepointHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class CuepointHandler extends WowzaApiClient
{
    /**@var CuepointHelper $cuepointHelper */
    private $cuepointHelper;
    private $data = [];

    /**
     * @param array          $wowzaConfig
     * @param Client         $client
     * @param CuepointHelper $cuepointHelper
     */
    public function __construct(array $wowzaConfig, Client $client, CuepointHelper $cuepointHelper)
    {
        parent::__construct($wowzaConfig, $client);

        $this->cuepointHelper = $cuepointHelper;
        $this->data           = [
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
     * @param string $text
     *
     * @return JsonResponse
     */
    public function insertCuepoint($streamname, $text)
    {
        $this->data['action']     = 'cuepoint';
        $this->data['streamname'] = $streamname;
        $this->data['text']       = $text;

        $url            = $this->cuepointHelper->buildUrl('livesetmetadata', $this->data);
        $result         = $this->cuepointHelper->call($this->data, $url, $this->client);
        $parsedResponse = $this->cuepointHelper->parseResponse($result, $this->data);

        return new JsonResponse($parsedResponse, $parsedResponse['code']);
    }
}
