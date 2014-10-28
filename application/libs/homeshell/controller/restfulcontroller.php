<?php

require_once dirname(__FILE__) . '/sessioncontroller.php';

abstract class RestfulController extends SessionController{
    
    abstract public function onGet($args);
    abstract public function onPost($args);
    abstract public function onDelete($args);
    
}

