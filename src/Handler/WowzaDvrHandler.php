<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaDvrHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Dvr\WowzaDvr;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class WowzaDvrHandler extends WowzaApiClient implements DvrHandler
{
    /**@var WowzaDvrHelper $dvrHelper */
    private $dvrHelper;
    /**@var WowzaDvr $dvr */
    private $dvr;

    /**
     * DvrHandler constructor.
     *
     * @param Client         $client
     * @param WowzaDvrHelper $dvrHelper
     * @param WowzaDvr       $dvr
     */
    public function __construct(
        Client $client,
        WowzaDvrHelper $dvrHelper,
        WowzaDvr $dvr
    )
    {
        parent::__construct($client);

        $this->dvrHelper = $dvrHelper;
        $this->dvr       = $dvr;
    }

    /**
     * @inheritDoc
     */
    public function startDvr($streamname, $recordingname)
    {
        $this->dvr->setAction('start');

        return $this->dvrTask($streamname, $recordingname);
    }

    /**
     * @inheritDoc
     */
    public function stopDvr($streamname, $recordingname)
    {
        $this->dvr->setAction('stop');

        return $this->dvrTask($streamname, $recordingname);
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

    /**
     * @param string $streamname
     * @param string $recordingname
     *
     * @return bool
     */
    private function dvrTask($streamname, $recordingname)
    {
        $this->dvr->setStreamname($streamname);
        $this->dvr->setRecordingname($recordingname);

        $url = $this->dvrHelper->buildUrl('dvrstreamrecord', $this->wowzaConfig, $this->dvr);
        $this->dvrHelper->call($this->wowzaConfig, $url, $this->client);

        return true;
    }
}
