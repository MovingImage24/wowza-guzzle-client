<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Tests\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaDvrHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Dvr\WowzaDvr;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use PHPUnit\Framework\TestCase;

class DvrHelperTest extends TestCase
{
    private WowzaDvrHelper $obj;

    private WowzaConfig $wowzaConfig;

    public function setUp(): void
    {
        $this->obj = new WowzaDvrHelper();
        $this->wowzaConfig = new WowzaConfig();
        $this->wowzaConfig->setApiUrl('http://host:123');
        $this->wowzaConfig->setApp('app');
        $this->wowzaConfig->setUsername('foo');
        $this->wowzaConfig->setPassword('bar');
    }

    /**
     * @test
     * @throws GuzzleException
     * @throws MiException
     */
    public function call(): void
    {
        $result = $this->obj->call($this->wowzaConfig, 'url', $this->getClient(200, 'bar'));
        self::assertEquals('bar', $result->getBody()->getContents());
    }

    /**
     * @test
     *
     * @throws GuzzleException
     * @throws MiException
     */
    public function callMiException()
    {
        $this->expectException(MiException::class);
        $this->expectExceptionMessage("Client error: `GET url` resulted in a `404 Not Found` response");

        $this->obj->call($this->wowzaConfig, 'url', $this->getClient(404));
    }

    /**
     * @test
     */
    public function buildUrl()
    {
        $dvr = new WowzaDvr();
        $dvr->setAction('start');
        $dvr->setStreamname('stream');
        $dvr->setRecordingname('recording');
        $result = $this->obj->buildUrl('foo', $this->wowzaConfig, $dvr);
        $expected = 'http://host:123/foo?app=app&streamname=stream&recordingname=recording&action=start';

        self::assertEquals($expected, $result);
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
