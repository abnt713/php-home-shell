<?php

class ServiceRunner extends HomeShellSubController{
    
    public function callService($applianceId, $args){
        $serviceName = $args[REQUEST_ACTION];
        $appliancesModel = $this->loadModel('AppliancesModel');
        $appliance = $appliancesModel->getAppliance($applianceId);
        
        if(!$appliance){
            $this->addLocalizedMessage('appliance-not-found');
            $this->end();
        }
        
        $address = $appliance->address;
        $handler = new UrlHandler('http://' . $address . '/services/' . $serviceName, 'GET');
        $handler->setTimeout(10);
        $handler->run();
        
        // Verificar erros mais tarde
        
        $this->setStatus(1);
        $this->addLocalizedMessage('operation-success');
        $this->end();
    }
    
}

