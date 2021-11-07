<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use PHPUnit\Framework\TestCase;

class WowzaApiClientTest extends TestCase
{
    private WowzaConfig $wowzaConfig;

    /**
     * @throws GuzzleException
     */
    public function setUp(): void
    {
        $this->wowzaConfig = new WowzaConfig();
        $this->wowzaConfig->setApiUrl('http://host:123');
        $this->wowzaConfig->setApp('app');
        $this->wowzaConfig->setUsername('foo');
        $this->wowzaConfig->setPassword('bar');
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function correctWowza(): void
    {
        $wowzaApiClient = new WowzaApiClient($this->getClient(200));
        $result = $wowzaApiClient->checkWowzaConfig($this->wowzaConfig);

        self::assertEquals(200, $result);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function wrongWowzaHost(): void
    {
        $wowzaApiClient = new WowzaApiClient($this->getClient(404));

        $result = $wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        self::assertEquals(404, $result);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function wrongWowzaPass(): void
    {
        $wowzaApiClient = new WowzaApiClient($this->getClient(401));

        $result = $wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        self::assertEquals(401, $result);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function wowzaTimeout()
    {
        $wowzaApiClient = new WowzaApiClient($this->getClient(408));

        $result = $wowzaApiClient->checkWowzaConfig($this->wowzaConfig);
        self::assertEquals(408, $result);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function wowzaInternalError(): void
    {
        $wowzaApiClient = new WowzaApiClient($this->getClient(500));
        $result = $wowzaApiClient->checkWowzaConfig($this->wowzaConfig);

        self::assertEquals(500, $result);
    }

    /**
     * @param       $statusCode
     * @param       $body
     * @param array $headers
     *
     * @return Client
     */
    private function getClient($statusCode, $body = '', $headers = []): Client
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
