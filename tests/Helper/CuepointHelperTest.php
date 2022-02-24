<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Tests\Helper;

use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaCuepointHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint\Response as ResponseCupoint;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint\WowzaCuepoint;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use PHPUnit\Framework\TestCase;

class CuepointHelperTest extends TestCase
{
    private WowzaCuepointHelper $obj;

    private WowzaConfig $wowzaConfig;

    public function setUp(): void
    {
        $this->obj = new WowzaCuepointHelper();
        $this->wowzaConfig = new WowzaConfig();
        $this->wowzaConfig->setApiUrl('http://host:123');
        $this->wowzaConfig->setApp('app');
        $this->wowzaConfig->setUsername('foo');
        $this->wowzaConfig->setPassword('bar');
    }

    /**
     * @test
     */
    public function buildUrlTest(): void
    {
        $cuepoint = new WowzaCuepoint();
        $cuepoint->setStreamname('stream');
        $cuepoint->setText('{"foo":"bar","bla":1}');

        $result = $this->obj->buildUrl('foo', $this->wowzaConfig, $cuepoint);
        $expected = 'http://host:123/foo?app=app&streamname=stream&text=%7B%22foo%22%3A%22bar%22%2C%22bla%22%3A1%7D';

        self::assertEquals($expected, $result);
    }

    /**
     * @test
     * @throws MiException
     */
    public function parseValidResponse(): void
    {
        $response = new Response(200, ['foo' => 'bar'], 'Timestamp: 123');
        $result = $this->obj->getCuepointResponse($response);
        self::assertInstanceOf(ResponseCupoint::class, $result);
        self::assertEquals('123', $result->getTimestamp());
    }

    /**
     * @test
     */
    public function parseResponseWithIsRequiredException(): void
    {
        $this->expectException(MiException::class);
        $this->expectExceptionMessage('Something is wrong with the response of Wowza server: [body] foobar is required');

        $response = new Response('200', ['foo' => 'bar'], 'foobar is required');
        $this->obj->getCuepointResponse($response);
    }

    /**
     * @test
     */
    public function parseResponseWithNotFoundException(): void
    {
        $this->expectException(MiException::class);
        $this->expectExceptionMessage('Something is wrong with the response of Wowza server: [body] foobar not found');

        $response = new Response('200', ['foo' => 'bar'], 'foobar not found');
        $this->obj->getCuepointResponse($response);
    }
}
