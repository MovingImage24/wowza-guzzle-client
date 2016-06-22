<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaCuepointHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint\Response;
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
    /** @var Response  */
    private $cuepointResponse;

    /**
     * @param Client              $client
     * @param WowzaCuepointHelper $cuepointHelper
     * @param WowzaCuepoint       $cuepointModel
     * @param Response            $cuepointResponse
     */
    public function __construct(
        Client $client,
        WowzaCuepointHelper $cuepointHelper,
        WowzaCuepoint $cuepointModel,
        Response $cuepointResponse
    )
    {
        parent::__construct($client);

        $this->cuepointHelper   = $cuepointHelper;
        $this->cuepoint         = $cuepointModel;
        $this->cuepointResponse = $cuepointResponse;
    }

    /**
     * @inheritDoc
     */
    public function insertCuepoint($streamname, $text)
    {
        $this->cuepoint->setAction('cuepoint');
        $this->cuepoint->setStreamname($streamname);
        $this->cuepoint->setText($text);

        $url            = $this->cuepointHelper->buildUrl('livesetmetadata', $this->wowzaConfig, $this->cuepoint);
        $result         = $this->cuepointHelper->call($this->wowzaConfig, $url, $this->client);
        $parsedResponse = $this->cuepointHelper->parseResponse($result);
        $this->cuepointResponse->setTimestamp($parsedResponse);

        return $this->cuepointResponse;
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
}
