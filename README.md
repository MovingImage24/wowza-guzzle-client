API Bundle to use the Wowza REST API

#Config to use 

    mi_wowza_guzzle_client:
        wowza_admin: %wowza_admin%
        wowza_admin_password: %wowza_admin_password%
        wowza_protocol: %wowza_protocol%
        wowza_hostname: %wowza_hostname%
        wowza_dvr_port: %wowza_dvr_port%
        wowza_app: %wowza_app%

#AppKernel.php

    new MiWowzaGuzzleClientBundle()
    
#Use in a Serivce

## DVR
    
    <service id="yout_id.startdvr"
             class="Your\Class\StartDvr">
        <argument type="service" id="mi_wowza_dvr_handler"/>
    </service>

    <service id="your_id.stopdvr"
             class="Your\Class\StopDvr">
        <argument type="service" id="mi_wowza_dvr_handler"/>
    </service>

## Recording

        <service id="your_id.startrecording"
                 class="Your\Class\StartRecording">
            <argument type="service" id="mi_wowza_recording_handler"/>
        </service>

        <service id="your_id.stoprecording"
                 class="Your\Class\StopRecording">
            <argument type="service" id="mi_wowza_recording_handler"/>
        </service>

## Cuepoint

        <service id="your_id.set"
                 class="Your\Class\Set">
            <argument type="service" id="mi_wowza_cuepoint_handler"/>
        </service>