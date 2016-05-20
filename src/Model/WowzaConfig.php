<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\Model;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 */
final class WowzaConfig
{
    private $wowzaConfig;
    private $wowzaProtocol;
    private $wowzaHostname;
    private $wowzaDvrPort;
    private $wowzaAdmin;
    private $wowzaAdminPassword;
    private $wowzaApp;

    /**
     * WowzaConfig constructor.
     *
     * @param array $wowzaConfig
     */
    public function __construct(array $wowzaConfig)
    {
        $this->wowzaConfig        = $wowzaConfig;
        $this->wowzaProtocol      = $wowzaConfig['wowza_protocol'];
        $this->wowzaHostname      = $wowzaConfig['wowza_hostname'];
        $this->wowzaDvrPort       = $wowzaConfig['wowza_dvr_port'];
        $this->wowzaAdmin         = $wowzaConfig['wowza_admin'];
        $this->wowzaAdminPassword = $wowzaConfig['wowza_admin_password'];
        $this->wowzaApp           = $wowzaConfig['wowza_app'];
    }


    /**
     * @return mixed
     */
    public function getWowzaConfig()
    {
        return $this->wowzaConfig;
    }

    /**
     * @return mixed
     */
    public function getWowzaProtocol()
    {
        return $this->wowzaProtocol;
    }

    /**
     * @return mixed
     */
    public function getWowzaHostname()
    {
        return $this->wowzaHostname;
    }

    /**
     * @return mixed
     */
    public function getWowzaDvrPort()
    {
        return $this->wowzaDvrPort;
    }

    /**
     * @return mixed
     */
    public function getWowzaAdmin()
    {
        return $this->wowzaAdmin;
    }

    /**
     * @return mixed
     */
    public function getWowzaAdminPassword()
    {
        return $this->wowzaAdminPassword;
    }

    /**
     * @return mixed
     */
    public function getWowzaApp()
    {
        return $this->wowzaApp;
    }
    
}
