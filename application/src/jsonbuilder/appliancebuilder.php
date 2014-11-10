<?php

require_once 'application/src/jsonbuilder/servicebuilder.php';
require_once 'application/src/jsonbuilder/statusbuilder.php';

class ApplianceBuilder{
    
    public function getFullAppliance($appliance, $services, $status){
        $servicesJson = array();
        $serviceBuilder = new ServiceBuilder();
        foreach ($services as $service) {
            $servicesJson[] = $serviceBuilder->getService($service);
        }

        $statusJson = array();
        $statusBuilder = new StatusBuilder();
        foreach ($status as $singleStatus) {
            $statusBuilder->getStatus($singleStatus, $statusJson);
            //$statusJson[$singleStatus->status_name] = $singleStatus->status_value;
        }

        $json = array(
            'id' => $appliance->appliance_id,
            'type' => $appliance->type,
            'name' => $appliance->type,
            'services' => $servicesJson,
            'status' => $statusJson
        );
        
        return $json;
    }
    
}