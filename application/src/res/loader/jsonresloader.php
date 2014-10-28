<?php

require_once dirname(__FILE__) . '/resloader.php';

class JsonResLoader implements ResLoader{
    
    public function loadResource($resourceURI) {
        if(!is_file($resourceURI)){
            throw new Exception('JsonResLoader: Resource URI is not a file');
        }
        
        $fileContents = file_get_contents($resourceURI);
        $jsonContents = json_decode($fileContents, true);
        
        if(is_null($jsonContents)){
            throw new Exception('JsonResLoader: File does not provide valid JSON content');
        }
        
        return $jsonContents;
    }

}