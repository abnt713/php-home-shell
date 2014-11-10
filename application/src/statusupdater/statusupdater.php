<?php

class StatusUpdater {
    
    public function updateApplianceStatus($applianceId, $address, $statusModel){
        $url = $address;
        
        $statusUrl = $url . '/status';
        $urlHandler = new UrlHandler($statusUrl);
        $urlHandler->run();
        
        if($urlHandler->getStatus() != '200'){
            return false;
        }
        
        $stringJson = $urlHandler->getContent();
        $lampStatus = json_decode($stringJson, true);
        
        foreach($lampStatus as $statusName => $value){
            
            if(!$statusModel->updateStatusByName($applianceId, $statusName, $value)){
                return false;
            }
            
        }
        
        return true;
    }
    
}
