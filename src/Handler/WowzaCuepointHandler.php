<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaCuepointHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint\WowzaCuepoint;
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
    /**@var WowzaCuepoint $cuepoint */
    private $cuepoint;

    /**
     * @param WowzaConfig         $wowzaConfig
     * @param Client              $client
     * @param WowzaCuepointHelper $cuepointHelper
     * @param WowzaCuepoint       $cuepointModel
     */
    public function __construct(
        WowzaConfig $wowzaConfig,
        Client $client,
        WowzaCuepointHelper $cuepointHelper,
        WowzaCuepoint $cuepointModel
    )
    {
        parent::__construct($wowzaConfig, $client);

        $this->cuepointHelper = $cuepointHelper;
        $this->cuepoint       = $cuepointModel;
    }

    /**
     * @param string $streamname
     * @param string $text
     *
     * @return JsonResponse
     */
    public function insertCuepoint($streamname, $text)
    {
        $this->cuepoint->setAction('cuepoint');
        $this->cuepoint->setStreamname($streamname);
        $this->cuepoint->setText($text);

        $url            = $this->cuepointHelper->buildUrl('livesetmetadata', $this->wowzaConfig, $this->cuepoint);
        $result         = $this->cuepointHelper->call($this->wowzaConfig, $url, $this->client);
        $parsedResponse = $this->cuepointHelper->parseResponse($result, $this->cuepoint);

        return new JsonResponse($parsedResponse, $parsedResponse['code']);
    }
}
