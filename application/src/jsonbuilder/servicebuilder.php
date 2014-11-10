<?php

class ServiceBuilder{
    
    public function getService($service){
        return array('name' => $service->service_trigger);
    }
    
}