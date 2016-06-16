<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Exception;

/**
 * @author Volker Bredow <volker.bredow@movingimage.com>
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
class MiException extends \Exception
{
    public function __construct($message = 'Something went wrong!')
    {
        parent::__construct($message);
    }
}
