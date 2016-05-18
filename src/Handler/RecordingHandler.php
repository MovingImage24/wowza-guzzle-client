<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
interface RecordingHandler
{

    /**
     * @param string $streamname
     * @param string $option
     *
     * @return JsonResponse
     */
    public function startRecording($streamname, $option = 'append');

    /**
     * @param string $streamname
     * @param string $option
     *
     * @return JsonResponse
     */
    public function stopRecording($streamname, $option = 'append');
}
