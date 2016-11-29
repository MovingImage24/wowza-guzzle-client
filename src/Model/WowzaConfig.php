<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
final class WowzaConfig implements Config
{
    /** @var string */
    private $username;
    /** @var string */
    private $password;
    /** @var string */
    private $app;
    /** @var string */
    private $apiUrl;
    /** @var string */
    private $playoutUrl;

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @inheritDoc
     */
    public function setApp($app)
    {
        $this->app = $app;
    }

    /**
     * @inheritDoc
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @inheritDoc
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @inheritDoc
     */
    public function getPlayoutUrl()
    {
        return $this->playoutUrl;
    }

    /**
     * @inheritDoc
     */
    public function setPlayoutUrl($playoutUrl)
    {
        $this->playoutUrl = $playoutUrl;
    }
}
