<?php

abstract class ResManager{
    
    protected $resource;
    
    public function __construct(ResLoader $builder, $resourceURI){
        $this->resource = $builder->loadResource($resourceURI);
    }
    
    abstract public function getString($identifier);
    
}

