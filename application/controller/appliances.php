<?php

class Appliances extends HomeShellController {

    public function onDelete($args) {
        $this->setStatus(0);
        $this->addLocalizedMessage('invalid-request');
        $this->addLiteralMessage('Appliances request cannot answer to DELETE method');
        $this->end();
    }

    public function onGet($args) {
        $this->forceLogin();
        if (count($args) > (argsCount(REQUEST_CONTROLLER))) {
            // There is a id reference at the url
            $entityId = $args[REQUEST_ENTITY];
            $applianceHandler = $this->loadSubController('ApplianceHandler');
            $applianceHandler->handleSingleAppliance($entityId, $args);
        } else {
            $this->getAllAppliances();
        }
    }

    public function onPost($args) {
        $this->forceLogin();
        if(count($args) > argsCount(REQUEST_SUBTYPE)) {
            $applianceId = $args[REQUEST_ENTITY];
            $serviceRunner = $this->loadSubController('ServiceRunner');
            $serviceRunner->callService($applianceId, $args);
        } else {
            $this->setStatus(0);
            $this->addLocalizedMessage('invalid-request');
            $this->addLiteralMessage('Appliance POST must be used only for service calling');
            $this->end();
        }
    }

    private function getAllAppliances() {
        $appliancesModel = $this->loadModel('AppliancesModel');
        
        $appliances = $appliancesModel->getAllAppliances();
        $json = array();
        foreach($appliances as $appliance){
            $applianceId = $appliance->appliance_id;
            $services = $appliancesModel->getApplianceServices($applianceId);
            $status = $appliancesModel->getApplianceStatus($applianceId);

            $servicesJson = array();
            foreach ($services as $service) {
                $servicesJson[] = array(
                    'name' => $service->service_trigger
                );
            }

            $statusJson = array();
            foreach ($status as $singleStatus) {
                $statusJson[] = array(
                    $singleStatus->status_key => $singleStatus->status_value
                );
            }
            
            $applianceJson = array(
                'id' => $appliance->appliance_id,
                'type' => $appliance->type,
                'services' => $servicesJson,
                'status' => $statusJson
            );
            
            $json[] = $applianceJson;
        }

        $this->setStatus(1);
        $this->addLocalizedMessage('operation-success');
        $this->addContent('appliances', $json);
        $this->end();
    }

}
