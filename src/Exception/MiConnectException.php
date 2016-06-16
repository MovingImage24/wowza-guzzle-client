<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Exception;

/**
 * @author Volker Bredow <volker.bredow@movingimage.com>
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class MiConnectException extends MiException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
