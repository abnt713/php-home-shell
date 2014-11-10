<?php

require_once 'application/src/statusupdater/statusupdater.php';

class Update extends HomeShellController{
    
    public function onGet($args){
        $this->addLocalizedMessage('invalid-request');
        $this->addLiteralMessage('Resource unavailable for GET requests');
        $this->end();
    }
    
    public function onPost($args){
        $applianceKey = getIfSet($args, REQUEST_ENTITY);
        
        if(is_null($applianceKey)){
            $this->addLocalizedMessage('invalid-request');
            $this->addLiteralMessage('Appliance Key was not given');
            $this->end();
        }
        
        $appliancesModel = $this->loadModel('AppliancesModel');
        $appliance = $appliancesModel->getApplianceByKey($applianceKey);
        
        if(!$appliance){
            $this->addLocalizedMessage('appliance-not-found');
            $this->end();
        }
        
        
        $updater = new StatusUpdater();
        $updater->updateApplianceStatus($appliance->appliance_id, $appliance->address, $this->loadModel('StatusModel'));
        
        $this->setStatus(1);
        $this->addLocalizedMessage('operation-success');
        $this->end();
        
    }
    
    public function onDelete($args){
        $this->setStatus(0);
        $this->addLocalizedMessage('invalid-request');
        $this->addLiteralMessage('Resource unavailable for DELETE requests');
        $this->end();
    }
    
}
