<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model;

/**
 * @author Jan Arnold <jan.arnolf@movingimage.com>
 * @author Volker Bredow <volker.bredow@movingimage.com>
 */
interface Config
{
    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $username
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $password
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getApp();

    /**
     * @param string $app
     */
    public function setApp($app);

    /**
     * @return string
     */
    public function getApiUrl();

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl);
}
