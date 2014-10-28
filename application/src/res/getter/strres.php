<?php

require_once dirname(__FILE__) . '/resmanager.php';
require_once dirname(__FILE__) . '/../loader/jsonresloader.php';

class StrRes extends ResManager{
    
    private static $instance;
    private static $locale;
    
    private $defaultResource;
    
    public function __construct($locale) {
        $loader = new JsonResLoader();
        
        parent::__construct($loader, "locale/{$locale}/strings.json");
        $this->defaultResource = $loader->loadResource('locale/' . HOMESHELL_LOCALE . '/strings.json');
    }

    public function getString($identifier) {
        $validResource = isset($this->resource['contents'][$identifier]) ? $this->resource : $this->defaultResource;
        $value = isset($validResource['contents'][$identifier]) ? $validResource['contents'][$identifier] : null;
        
        $hasDecodeOption = isset($validResource['options']['decode']);
        if($hasDecodeOption){
            
        }
        
        return $value;
    }

    public static function setLocale($locale){
        self::$locale = $locale;
    }
    
    public static function getLocale(){
        return self::$locale;
    }
    
    public static function getInstance($forceReload = false){
        if(is_null(self::$instance) || $forceReload){
            self::$locale = is_null(self::$locale) ? HOMESHELL_LOCALE : self::$locale;
            self::$instance = new StrRes(self::$locale);
        }
        
        return self::$instance;
    }
    
    public static function get($identifier){
        $reader = self::getInstance();
        return $reader->getString($identifier);
    }
    
}

