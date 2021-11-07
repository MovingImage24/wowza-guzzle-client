<?php


namespace Mi\Bundle\WowzaGuzzleClientBundle\Tests\Helper;

use Mi\Bundle\WowzaGuzzleClientBundle\Helper\WowzaRecordingHelper;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording\WowzaRecording;
use Mi\Bundle\WowzaGuzzleClientBundle\Model\WowzaConfig;
use PHPUnit\Framework\TestCase;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 */
class RecordingHelperTest extends TestCase
{
    private WowzaRecordingHelper $obj;

    private WowzaConfig $wowzaConfig;

    public function setUp(): void
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
    public function buildUrlTest(): void
    {
        $recording = new WowzaRecording();
        $recording->setAction('startRecording');
        $recording->setStreamname('stream');
        $result = $this->obj->buildUrl('foo', $this->wowzaConfig, $recording, 'foobar');
        $expected =
            'http://host:123/foo?app=app&streamname=stream&option=&action=startRecording&outputFile=foobar_stream.mp4';

        self::assertEquals($expected, $result);
    }
}
