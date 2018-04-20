<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaDvrHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Dvr\WowzaDvr;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 */
class DvrHelperTest extends \PHPUnit_Framework_TestCase
{
    /**@var WowzaDvrHelper $obj */
    private $obj;
    /**@var WowzaConfig $wowzaConfig */
    private $wowzaConfig;

    public function setUp()
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     */
    public function call()
    {
        $result = $this->obj->call($this->wowzaConfig, 'url', $this->getClient(200, 'bar'));
        $this->assertEquals('bar', $result->getBody()->getContents());
    }

    /**
     * @test
     *
     * @expectedException \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     */
    public function callMiException()
    {
        $result = $this->obj->call($this->wowzaConfig, 'url', $this->getClient(404));
        $this->assertEquals(404, $result->getStatusCode());
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

        $this->assertEquals($expected, $result);
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
