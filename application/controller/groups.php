<?php

class Groups extends HomeShellController{
    
    
    public function onDelete($args) {
        
    }

    public function onGet($args) {
        $this->forceLogin();
        if (count($args) > (argsCount(REQUEST_CONTROLLER))) {
            // There is a id reference at the url
            $entityId = $args[REQUEST_ENTITY];
            $groupgather = $this->loadSubController('GroupGather');
            $groupgather->gatherSingleGroup($entityId, $args);
        } else {
            $this->gatherAllAppliances();
        }
    }

    public function onPost($args) {
        
    }

    private function gatherAllAppliances(){
        $groupsModel = $this->loadModel('GroupsModel');
        $appliancesModel = $this->loadModel('AppliancesModel');
        $allGroups = $groupsModel->getAllGroups();
        
        $groupsJson = array();
        foreach($allGroups as $group){
            
            $allAppliances = $groupsModel->getAllAppliancesFromGroup($group->group_id);
            $appliancesJson = array();
            foreach($allAppliances as $applianceId){
                $appliance = $appliancesModel->getAppliance($applianceId->appliance_id);
                
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
                    $statusJson[$singleStatus->status_name] = $singleStatus->status_value;
                }

                $applianceJson = array(
                    'id' => $appliance->appliance_id,
                    'type' => $appliance->type,
                    'name' => $appliance->type,
                    'services' => $servicesJson,
                    'status' => $statusJson
                );

                $appliancesJson[] = $applianceJson;
                
            }
            
            $group = array(
                'id' => $group->group_id,
                'name' => $group->name,
                'appliances' => $appliancesJson
            );
            
            $groupsJson[] = $group;
        }
        
        
        $this->setStatus(1);
        $this->addLocalizedMessage('operation-success');
        $this->addContent('groups', $groupsJson);
        
        $this->end();
    }
    
}

