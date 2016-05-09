<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle;

use GuzzleHttp\Client;

/**
 * @author Jan Arnold <jan.arnold@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class WowzaApiClient
{
    protected $wowzaConfig;
    protected $wowzaProtocol;
    protected $wowzaHostname;
    protected $wowzaDvrPort;
    protected $wowzaAdmin;
    protected $wowzaAdminPassword;
    protected $wowzaApp;
    protected $client;

    /**
     * WowzaApiClient constructor.
     *
     * @param array  $wowzaConfig
     * @param Client $client
     */
    public function __construct(array $wowzaConfig, Client $client)
    {
        $this->wowzaConfig        = $wowzaConfig[0];
        $this->client             = $client;
        $this->wowzaProtocol      = $this->wowzaConfig['wowza_protocol'];
        $this->wowzaHostname      = $this->wowzaConfig['wowza_hostname'];
        $this->wowzaDvrPort       = $this->wowzaConfig['wowza_dvr_port'];
        $this->wowzaAdmin         = $this->wowzaConfig['wowza_admin'];
        $this->wowzaAdminPassword = $this->wowzaConfig['wowza_admin_password'];
        $this->wowzaApp           = $this->wowzaConfig['wowza_app'];
    }
}
