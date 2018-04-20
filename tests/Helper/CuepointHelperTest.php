<?php


namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper\Tests;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Stream\Stream;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaCuepointHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint\WowzaCuepoint;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 */
class CuepointHelperTest extends \PHPUnit_Framework_TestCase
{
    /**@var WowzaCuepointHelper $obj */
    private $obj;
    /**@var WowzaConfig $wowzaConfig */
    private $wowzaConfig;

    public function setUp()
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

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     * @throws \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     */
    public function parseValidResponse()
    {
        $response = new Response(200, ['foo' => 'bar'], Stream::factory('Timestamp: 123'));
        $result = $this->obj->parseResponse($response);
        $this->assertEquals('123', $result);
    }

    /**
     * @test
     *
     * @expectedException \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     */
    public function parseResponseWithIsRequiredException()
    {
        $cuepoint = new WowzaCuepoint();
        $cuepoint->setText('cuepointfoo');
        $response = new Response('200', ['foo' => 'bar'], Stream::factory('foobar is required'));
        $this->obj->parseResponse($response);
    }

    /**
     * @test
     *
     * @expectedException \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     */
    public function parseResponseWithNotFoundException()
    {
        $cuepoint = new WowzaCuepoint();
        $cuepoint->setText('cuepointfoo');
        $response = new Response('200', ['foo' => 'bar'], Stream::factory('foobar not found'));
        $result = $this->obj->parseResponse($response);
        $this->assertEquals(
            [
                'code' => 400,
                'message' => 'Bad Request'
            ],
            $result
        );
    }
}
