<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
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

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setUp()
    {
        $this->wowzaConfig = new WowzaConfig();
        $this->wowzaConfig->setApiUrl('http://host:123');
        $this->wowzaConfig->setApp('app');
        $this->wowzaConfig->setUsername('foo');
        $this->wowzaConfig->setPassword('bar');
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function correctWowza()
    {
        $wowzaApiClient = new WowzaApiClient($this->getClient(200));

        $result = $wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(200, $result);
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function wrongWowzaHost()
    {
        $wowzaApiClient = new WowzaApiClient($this->getClient(404));

        $result = $wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(404, $result);
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function wrongWowzaPass()
    {
        $wowzaApiClient = new WowzaApiClient($this->getClient(401));

        $result = $wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(401, $result);
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function wowzaTimeout()
    {
        $wowzaApiClient = new WowzaApiClient($this->getClient(408));

        $result = $wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(408, $result);
    }

    /**
     * @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function wowzaInternalError()
    {
        $wowzaApiClient = new WowzaApiClient($this->getClient(500));

        $result = $wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        $this->assertEquals(500, $result);
    }

    /**
     * @param       $statusCode
     * @param       $body
     * @param array $headers
     *
     * @return Client
     */
    private function getClient($statusCode, $body = '', $headers = [])
    {
        $mock = new MockHandler([
            new Response($statusCode, $headers, $body),
        ]);
        $handler = HandlerStack::create($mock);

        return new Client([
            'handler' => $handler
        ]);
    }
}
