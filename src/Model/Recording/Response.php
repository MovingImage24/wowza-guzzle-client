<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model\Recording;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 * @author Volker Bredow <volker.bredow@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class Response
{
    /** @var bool */
    private $success;

    /**
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param boolean $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }
}
