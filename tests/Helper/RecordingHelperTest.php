<?php


namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper\Tests;

use GuzzleHttp\Psr7\Response;
use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaRecordingHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording\WowzaRecording;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 */
class RecordingHelperTest extends \PHPUnit_Framework_TestCase
{
    /**@var WowzaRecordingHelper $obj */
    private $obj;
    /**@var WowzaConfig $wowzaConfig*/
    private $wowzaConfig;

    public function setUp()
    {
        $this->obj = new WowzaRecordingHelper();
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
    public function buildUrlTest()
    {
        $recording = new WowzaRecording();
        $recording->setAction('startRecording');
        $recording->setStreamname('stream');
        $result   = $this->obj->buildUrl('foo', $this->wowzaConfig, $recording);
        $expected = 'http://host:123/foo?app=app&streamname=stream&action=startRecording';

        $this->assertEquals($expected, $result);
    }
}
