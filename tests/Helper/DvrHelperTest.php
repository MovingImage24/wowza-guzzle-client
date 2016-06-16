<?php


namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper\Tests;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
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
    /**@var WowzaConfig $wowzaConfig*/
    private $wowzaConfig;

    public function setUp()
    {
        $this->obj = new WowzaDvrHelper();
        $data     = [
            'wowza_protocol' => 'http',
            'wowza_hostname' => 'host',
            'wowza_dvr_port'  => '123',
            'wowza_app'      => 'app',
            'wowza_admin'         => 'foo',
            'wowza_admin_password' => 'bar'
            
        ];
        $this->wowzaConfig = new WowzaConfig($data);
    }

    /**
     * @test
     */
    public function call()
    {
        $guzzleClient = $this->prophesize('\GuzzleHttp\Client');
        $guzzleClient->request(
            'GET',
            'url',
            [
                'auth' => ['foo', 'bar', 'Digest']
            ]
        )->shouldBeCalled('1')->willReturn('foo');

        $result = $this->obj->call($this->wowzaConfig, 'url', $guzzleClient->reveal());
        $this->assertEquals('foo', $result);
    }

    /**
     * @test
     *
     * @expectedException \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiException
     */
    public function callMiException()
    {
        $response = new Response(404, ['foo' => 'bar'], 'Something went wrong');
        $request = $this->prophesize('\GuzzleHttp\Psr7\Request');
        $guzzleClient = $this->prophesize('\GuzzleHttp\Client');
        $guzzleClient->request(
            'GET',
            'url',
            [
                'auth' => ['foo', 'bar', 'Digest']
            ]
        )->shouldBeCalled('1')->willThrow(new ClientException('exception', $request->reveal(), $response));

        $result = $this->obj->call($this->wowzaConfig, 'url', $guzzleClient->reveal());
        $this->assertEquals($response->getStatusCode(), $result->getStatusCode());
    }

    /**
     * @test
     *
     * @expectedException \Mi\Bundle\WowzaGuzzleClientBundle\Exception\MiConnectException
     */
    public function callMiConnectException()
    {
        $response = new Response(400, ['foo' => 'bar'], 'baz');
        $request = $this->prophesize('\GuzzleHttp\Psr7\Request');
        $guzzleClient = $this->prophesize('\GuzzleHttp\Client');
        $guzzleClient->request(
            'GET',
            'url',
            [
                'auth' => ['foo', 'bar', 'Digest']
            ]
        )->shouldBeCalled('1')->willThrow(new ConnectException('exception', $request->reveal()));
        $result = $this->obj->call($this->wowzaConfig, 'url', $guzzleClient->reveal());
        $this->assertEquals($response->getStatusCode(), $result->getStatusCode());
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
