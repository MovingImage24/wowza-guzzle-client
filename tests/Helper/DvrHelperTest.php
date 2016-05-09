<?php


namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper\Tests;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\DvrHelper;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 */
class DvrHelperTest extends \PHPUnit_Framework_TestCase
{
    /**@var DvrHelper $obj */
    private $obj;

    public function setUp()
    {
        $this->obj = new DvrHelper();
    }

    /**
     * @test
     */
    public function callTest()
    {
        $data         = [
            'wowzaAdmin'         => 'foo',
            'wowzaAdminPassword' => 'bar'
        ];
        $guzzleClient = $this->prophesize('\GuzzleHttp\Client');
        $guzzleClient->request(
            'GET',
            'url',
            [
                'auth' => ['foo', 'bar', 'Digest']
            ]
        )->shouldBeCalled('1')->willReturn('foo');

        $result = $this->obj->call($data, 'url', $guzzleClient->reveal());
        $this->assertEquals('foo', $result);
    }

    /**
     * @test
     */
    public function callExceptionTest()
    {
        $data         = [
            'wowzaAdmin'         => 'foo',
            'wowzaAdminPassword' => 'bar'
        ];
        $response     = new Response(404, ['foo' => 'bar'], 'Something went wrong');
        $request      = $this->prophesize('\GuzzleHttp\Psr7\Request');
        $guzzleClient = $this->prophesize('\GuzzleHttp\Client');
        $guzzleClient->request(
            'GET',
            'url',
            [
                'auth' => ['foo', 'bar', 'Digest']
            ]
        )->shouldBeCalled('1')->willThrow(new ClientException('exception', $request->reveal(), $response));

        $result = $this->obj->call($data, 'url', $guzzleClient->reveal());
        $this->assertEquals($response->getStatusCode(), $result->getStatusCode());

        $response = new Response(400, ['foo' => 'bar'], 'baz');
        $guzzleClient->request(
            'GET',
            'url',
            [
                'auth' => ['foo', 'bar', 'Digest']
            ]
        )->shouldBeCalled('1')->willThrow(new ConnectException('exception', $request->reveal()));
        $result = $this->obj->call($data, 'url', $guzzleClient->reveal());
        $this->assertEquals($response->getStatusCode(), $result->getStatusCode());
    }

    /**
     * @test
     */
    public function buildUrlTest()
    {
        $data     = [
            'wowzaProtocol' => 'http',
            'wowzaHostname' => 'host',
            'wowzaDvrPort'  => '123',
            'wowzaApp'      => 'app',
            'streamname'    => 'stream',
            'recordingname' => 'recording',
            'action'        => 'start'
        ];
        $result   = $this->obj->buildUrl('foo', $data);
        $expected = 'http://host:123/foo?app=app&streamname=stream&recordingname=recording&action=start';

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function parseResponseTest()
    {
        $data     = [
            'streamname' => 'foo',
            'action'     => 'start'
        ];
        $response = new Response(200, ['foo' => 'bar'], 'stream foo started as b');
        $result   = $this->obj->parseResponse($response, $data);
        $this->assertEquals(
            [
                'code'    => 200,
                'message' => [
                    'action'        => 'start_dvr',
                    'recordingName' => 'b'
                ]
            ],
            $result
        );

        $response = new Response(404, ['foo' => 'bar'], 'Live stream foo does not exist');
        $result   = $this->obj->parseResponse($response, $data);
        $this->assertEquals(
            [
                'code'    => 404,
                'message' => 'foo does not exist'
            ],
            $result
        );

        $response = new Response(401, ['foo' => 'bar'], 'baz');
        $result   = $this->obj->parseResponse($response, $data);
        $this->assertEquals(
            [
                'code'    => 401,
                'message' => 'Bad credentials'
            ]
            ,
            $result
        );
    }
}