<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaCuepointHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint\WowzaCuepoint;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class WowzaCuepointHandler extends WowzaApiClient implements CuepointHandler
{
    private WowzaCuepointHelper $cuepointHelper;

    private WowzaCuepoint $cuepoint;

    public function __construct(
        Client $client,
        WowzaCuepointHelper $cuepointHelper,
        WowzaCuepoint $cuepointModel,
    ) {
        parent::__construct($client);

        $this->cuepointHelper = $cuepointHelper;
        $this->cuepoint = $cuepointModel;
    }

    public function insertCuepoint($streamname, $text): Response
    {
        $this->cuepoint->setAction('cuepoint');
        $this->cuepoint->setStreamname($streamname);
        $this->cuepoint->setText($text);

        $url = $this->cuepointHelper->buildUrl('livesetmetadata', $this->wowzaConfig, $this->cuepoint);
        $result = $this->cuepointHelper->call($this->wowzaConfig, $url, $this->client);

        return $this->cuepointHelper->getCuepointResponse($result);
    }

    public function getConfig()
    {
        parent::getWowzaConfig();
    }

    public function setConfig($config)
    {
        parent::setWowzaConfig($config);
    }
}
