<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\WowzaApiClient;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

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
     * @test
     */
    public function wowzaRequestException(): void
    {
        $wowzaApiClient = new WowzaApiClient(
            $this->getClientThrowsException(new ConnectException("", new Request('get', 'GET')))
        );
        $result = $wowzaApiClient->checkWowzaConfig($this->wowzaConfig);

        self::assertEquals(HttpFoundationResponse::HTTP_BAD_REQUEST, $result);
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
        return $this->buildClient([
            new Response($statusCode, $headers, $body),
        ]);
    }

    private function getClientThrowsException(GuzzleException $exception): Client
    {
        return $this->buildClient([
            $exception,
        ]);
    }

    private function buildClient(array $queue): Client
    {
        $mock = new MockHandler($queue);
        $handler = HandlerStack::create($mock);

        return new Client([
            'handler' => $handler
        ]);
    }
}
