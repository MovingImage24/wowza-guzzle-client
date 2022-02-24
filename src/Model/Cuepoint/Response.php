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

    public function __construct(int $timestamp, string $body)
    {
        $this->timestamp = $timestamp;
        $this->body = $body;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }
}
