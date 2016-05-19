<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaCuepointHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class WowzaCuepointHandler extends WowzaApiClient implements CuepointHandler
{
    /**@var WowzaCuepointHelper $cuepointHelper */
    private $cuepointHelper;
    private $data = [];

    /**
     * @param WowzaConfig         $wowzaConfig
     * @param Client              $client
     * @param WowzaCuepointHelper $cuepointHelper
     */
    public function __construct(WowzaConfig $wowzaConfig, Client $client, WowzaCuepointHelper $cuepointHelper)
    {
        parent::__construct($wowzaConfig, $client);

        $this->cuepointHelper = $cuepointHelper;
//        $this->data           = [
//            'wowzaAdmin'         => $this->wowzaConfig->getWowzaAdmin(),
//            'wowzaAdminPassword' => $this->wowzaConfig->getWowzaAdminPassword(),
//            'wowzaProtocol'      => $this->wowzaConfig->getWowzaProtocol(),
//            'wowzaHostname'      => $this->wowzaConfig->getWowzaHostname(),
//            'wowzaDvrPort'       => $this->wowzaConfig->getWowzaDvrPort(),
//            'wowzaApp'           => $this->wowzaConfig->getWowzaApp()
//        ];
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

        $url            = $this->cuepointHelper->buildUrl('livesetmetadata', $this->wowzaConfig, $this->data);
        $result         = $this->cuepointHelper->call($this->wowzaConfig, $url, $this->client);
        $parsedResponse = $this->cuepointHelper->parseResponse($result, $this->data);

        return new JsonResponse($parsedResponse, $parsedResponse['code']);
    }
}
