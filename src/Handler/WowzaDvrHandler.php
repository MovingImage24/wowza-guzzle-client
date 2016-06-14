<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use GuzzleHttp\Client;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaDvrHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Dvr\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Dvr\WowzaDvr;
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
    /**@var WowzaDvr $dvr */
    private $dvr;
    /** @var  Response */
    private $dvrResponse;

    /**
     * DvrHandler constructor.
     *
     * @param WowzaConfig    $wowzaConfig
     * @param Client         $client
     * @param WowzaDvrHelper $dvrHelper
     * @param Response       $dvrResponse
     */
    public function __construct(
        WowzaConfig $wowzaConfig,
        Client $client,
        WowzaDvrHelper $dvrHelper,
        WowzaDvr $dvr,
        Response $dvrResponse
    )
    {
        parent::__construct($wowzaConfig, $client);

        $this->dvrHelper   = $dvrHelper;
        $this->dvr         = $dvr;
        $this->dvrResponse = $dvrResponse;
    }

    /**
     * @param string $streamname
     * @param string $recordingname
     *
     * @return JsonResponse
     */
    public function startDvr($streamname, $recordingname)
    {
        $this->dvr->setAction('start');

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
        $this->dvr->setAction('stop');

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
        $this->dvr->setStreamname($streamname);
        $this->dvr->setRecordingname($recordingname);

        $url            = $this->dvrHelper->buildUrl('dvrstreamrecord', $this->wowzaConfig, $this->dvr);
        $result         = $this->dvrHelper->call($this->wowzaConfig, $url, $this->client);
        $parsedResponse = $this->dvrHelper->parseResponse($result, $this->dvr);
        $this->dvrResponse->setRecordingName($parsedResponse);

        return $this->dvrResponse;
    }
}
