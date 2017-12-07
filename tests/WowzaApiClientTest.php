<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Psr7\Request;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;

class WowzaApiClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var Client $client */
    private $client;
    /** @var WowzaApiClient $obj */
    private $wowzaApiClient;
    /**@var WowzaConfig $wowzaConfig */
    private $wowzaConfig;
    /** @var Request $guzzleRequest */
    private $guzzleRequest;

    public function setUp()
    {
        $this->guzzleRequest = $this->prophesize('\GuzzleHttp\Message\Request');
        $this->client = $this->prophesize('\GuzzleHttp\Client');
        $this->wowzaApiClient = new WowzaApiClient($this->client->reveal());
        $this->wowzaConfig = new WowzaConfig();
        $this->wowzaConfig->setApiUrl('http://host:123');
        $this->wowzaConfig->setApp('app');
        $this->wowzaConfig->setUsername('foo');
        $this->wowzaConfig->setPassword('bar');

        $this->client->createRequest('GET',
            $this->wowzaConfig->getApiUrl() . '/livesetmetadata',
            [
                'auth' => ['foo', 'bar', 'Digest'],
                'query' => ['app' => $this->wowzaConfig->getApp()]
            ]
        )->shouldBeCalledTimes('1')->willReturn($this->guzzleRequest);
    }

    /**
     * @test
     */
    public function correctWowza() {
        $this->client->send($this->guzzleRequest)->shouldBeCalledTimes('1')->willReturn(new Response(200));

        $result = $this->wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(200, $result);
    }

    /**
     * @test
     */
    public function wrongWowzaHost() {
        $this->client->send($this->guzzleRequest)
            ->shouldBeCalledTimes('1')
            ->willReturn(new Response(404));

        $result = $this->wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(404, $result);
    }

    /**
     * @test
     */
    public function wrongWowzaPass() {
        $this->client->send($this->guzzleRequest)
            ->shouldBeCalledTimes('1')
            ->willReturn(new Response(401));

        $result = $this->wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(401, $result);
    }

    /**
     * @test
     */
    public function wowzaTimeout() {
        $this->client->send($this->guzzleRequest)
            ->shouldBeCalledTimes('1')
            ->willReturn(new Response(408));

        $result = $this->wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(408, $result);
    }

    /**
     * @test
     */
    public function wowzaInternalError() {
        $this->client->send($this->guzzleRequest)
            ->shouldBeCalledTimes('1')
            ->willReturn(new Response(500));

        $result = $this->wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(500, $result);
    }
}
