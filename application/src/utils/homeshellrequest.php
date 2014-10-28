<?php

class HomeShellRequest {
    
    private $inputType;
    private $user;
    private $validRequest;
    private $method;

    public function __construct() {
        $requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        $this->method = strtolower($requestMethod);
        $this->findInputType();
    }

    private function findInputType() {
        $this->validRequest = true;
        switch ($this->method) {
            case METHOD_GET:
                $this->inputType = INPUT_GET;
                break;
            case METHOD_POST:
                $this->inputType = INPUT_POST;
                break;
            case METHOD_DELETE:
                $this->inputType = -1;
                break;
            default:
                $this->validRequest = false;
                break;
        }
    }
    
    function isValid() {
        return $this->validRequest;
    }

    function getMethod() {
        return $this->method;
    }

    function getValue($index) {
        if($this->inputType == -1){
            return null;
        }
        
        return filter_input($this->inputType, $index);
    }

    function getUser() {
        return $this->user;
    }

    function setUser($user) {
        $this->user = $user;
    }



}
