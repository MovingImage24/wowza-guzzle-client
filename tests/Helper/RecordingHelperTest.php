<?php


namespace Mi\Bundle\WowzaGuzzleClientBundle\Helper\Tests;

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
    /**@var WowzaConfig $wowzaConfig */
    private $wowzaConfig;

    public function setUp()
    {
        $this->obj = new WowzaRecordingHelper();
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
        $recording = new WowzaRecording();
        $recording->setAction('startRecording');
        $recording->setStreamname('stream');
        $result = $this->obj->buildUrl('foo', $this->wowzaConfig, $recording, 'foobar');
        $expected =
            'http://host:123/foo?app=app&streamname=stream&option=&action=startRecording&outputFile=foobar_stream.mp4';

        $this->assertEquals($expected, $result);
    }
}
