<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model\Cuepoint;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 * @author Volker Bredow <volker.bredow@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class Response
{
    private int $timestamp;

    private string $body;

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function getBody(): string
    {
        return $this->body;
    }


    public function setBody(string $body):void
    {
        $this->body = $body;
    }
}
