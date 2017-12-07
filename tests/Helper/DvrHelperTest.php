<?php


namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
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
    /**@var WowzaConfig $wowzaConfig*/
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
     */
    public function call()
    {
        /** @var Client $guzzleClient */
        $guzzleClient = $this->prophesize('\GuzzleHttp\Client');
        $guzzleRequest = $this->prophesize('\GuzzleHttp\Message\Request');
        $guzzleClient->createRequest(
            'GET',
            'url',
            [
                'auth' => ['foo', 'bar', 'Digest']
            ]
        )->shouldBeCalledTimes('1')->willReturn($guzzleRequest);

        $guzzleClient->send($guzzleRequest)->shouldBeCalledTimes('1')->willReturn('bar');

        $result = $this->obj->call($this->wowzaConfig, 'url', $guzzleClient->reveal());
        $this->assertEquals('bar', $result);
    }

    /**
     * @test
     *
     * @expectedException \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     */
    public function callMiException()
    {
        $guzzleResponse = $this->prophesize('\GuzzleHttp\Message\Response');
        $guzzleRequest = $this->prophesize('\GuzzleHttp\Message\Request');

        /** @var Client $guzzleClient */
        $guzzleClient = $this->prophesize('\GuzzleHttp\Client');
        $guzzleClient->createRequest(
            'GET',
            'url',
            [
                'auth' => ['foo', 'bar', 'Digest']
            ]
        )->shouldBeCalledTimes('1')->willReturn($guzzleRequest);

        $guzzleClient
            ->send($guzzleRequest)
            ->shouldBeCalledTimes('1')
            ->willThrow(new ClientException('exception', $guzzleRequest->reveal(), $guzzleResponse->reveal()));

        $result = $this->obj->call($this->wowzaConfig, 'url', $guzzleClient->reveal());
        $this->assertEquals($guzzleResponse->getStatusCode(), $result->getStatusCode());
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
        $result   = $this->obj->buildUrl('foo', $this->wowzaConfig, $dvr);
        $expected = 'http://host:123/foo?app=app&streamname=stream&recordingname=recording&action=start';

        $this->assertEquals($expected, $result);
    }
}
