<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;

class WowzaApiClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var Client $client */
    private $client;
    /** @var  WowzaApiClient $obj */
    private $obj;
    /**@var WowzaConfig $wowzaConfig*/
    private $wowzaConfig;

    public function setUp()
    {
        $this->client = $this->prophesize('\GuzzleHttp\Client');
        $this->obj = new WowzaApiClient($this->client->reveal());
        $this->wowzaConfig = new WowzaConfig();
        $this->wowzaConfig->setApiUrl('http://host:123');
        $this->wowzaConfig->setApp('app');
        $this->wowzaConfig->setUsername('foo');
        $this->wowzaConfig->setPassword('bar');
    }

    /**
     * @test
     */
    public function correctWowza() {
        $guzzleRequest = $this->prophesize('\GuzzleHttp\Message\Request');
        $this->client->createRequest(
            'GET',
            $this->wowzaConfig->getApiUrl() . '/livesetmetadata?app=' . $this->wowzaConfig->getApp(),
            [
                'auth' => ['foo', 'bar', 'Digest']
            ]
        )->shouldBeCalledTimes('1')->willReturn($guzzleRequest);

        $this->client->send($guzzleRequest)->shouldBeCalledTimes('1')->willReturn(new Response(200));

        $result = $this->obj->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(200, $result);
    }

    /**
     * @test
     */
    public function wrongWowzaHost() {
        $guzzleRequest = $this->prophesize('\GuzzleHttp\Message\Request');
        $this->client->createRequest(
            'GET',
            $this->wowzaConfig->getApiUrl() . '/livesetmetadata?app=' . $this->wowzaConfig->getApp(),
            [
                'auth' => ['foo', 'bar', 'Digest']
            ]
        )->shouldBeCalledTimes('1')->willReturn($guzzleRequest);

        $this->client->send($guzzleRequest)
            ->shouldBeCalledTimes('1')
            ->willThrow(new \Exception('exception'));

        $result = $this->obj->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(404, $result);
    }

    /**
     * @test
     */
    public function wrongWowzaPass() {
        $guzzleRequest = $this->prophesize('\GuzzleHttp\Message\Request');
        $this->client->createRequest(
            'GET',
            $this->wowzaConfig->getApiUrl() . '/livesetmetadata?app=' . $this->wowzaConfig->getApp(),
            [
                'auth' => ['foo', 'bar', 'Digest']
            ]
        )->shouldBeCalledTimes('1')->willReturn($guzzleRequest);

        $this->client->send($guzzleRequest)
            ->shouldBeCalledTimes('1')
            ->willReturn(new Response(401));

        $result = $this->obj->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(401, $result);
    }
}