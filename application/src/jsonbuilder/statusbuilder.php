<?php

class StatusBuilder{
    
    public function getStatus($status, &$content){
        $content[$status->status_name] = $status->status_value;
    }
    
}