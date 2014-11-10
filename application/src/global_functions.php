<?php

function argsCount($value){
    return $value + 1;
}

function getIfSet($array, $index){
    return isset($array[$index]) ? $array[$index] : null ;
}

