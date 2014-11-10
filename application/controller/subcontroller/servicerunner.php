<?php

require_once 'application/src/statusupdater/statusupdater.php';

class ServiceRunner extends HomeShellSubController{
    
    public function callService($applianceId, $args){
        $serviceName = $args[REQUEST_ACTION];
        $appliancesModel = $this->loadModel('AppliancesModel');
        $appliance = $appliancesModel->getAppliance($applianceId);
        
        if(!$appliance){
            $this->addLocalizedMessage('appliance-not-found');
            $this->end();
        }
        
        $appliance = $appliancesModel->getAppliance($applianceId);

        if (!$appliance) {
            $this->addLocalizedMessage('appliance-not-found');
            $this->end();
        }

        $services = $appliancesModel->getApplianceServices($applianceId);
        $status = $appliancesModel->getApplianceStatus($applianceId);
        
        $builder = new ApplianceBuilder();
        $json = $builder->getFullAppliance($appliance, $services, $status);
        
        $address = $appliance->address;
        $handler = new UrlHandler('http://' . $address . '/services/' . $serviceName, 'GET');
        $handler->setTimeout(10);
        $handler->run();
        // Verificar erros mais tarde
        
        $updater = new StatusUpdater();
        $updater->updateApplianceStatus($appliance->appliance_id, $appliance->address, $this->loadModel('StatusModel'));
        
        $this->setStatus(1);
        $this->addLocalizedMessage('operation-success');
        $this->addContent('appliance', $json);
        $this->end();
    }
    
}

