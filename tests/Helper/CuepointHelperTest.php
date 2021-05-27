<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Tests\Helper;

use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaCuepointHelper;
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
    public function buildUrlTest()
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
     * @throws \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     */
    public function parseValidResponse()
    {
        $response = new Response(200, ['foo' => 'bar'], 'Timestamp: 123');
        $result = $this->obj->parseResponse($response);
        self::assertEquals('123', $result);
    }

    /**
     * @test
     */
    public function parseResponseWithIsRequiredException()
    {
        $this->expectException(MiException::class);
        $cuepoint = new WowzaCuepoint();
        $cuepoint->setText('cuepointfoo');
        $response = new Response('200', ['foo' => 'bar'], 'foobar is required');
        $this->obj->parseResponse($response);
    }

    /**
     * @test
     */
    public function parseResponseWithNotFoundException()
    {
        $this->expectException(MiException::class);

        $cuepoint = new WowzaCuepoint();
        $cuepoint->setText('cuepointfoo');
        $response = new Response('200', ['foo' => 'bar'], 'foobar not found');
        $result = $this->obj->parseResponse($response);
        self::assertEquals(
            [
                'code' => 400,
                'message' => 'Bad Request'
            ],
            $result
        );
    }
}
