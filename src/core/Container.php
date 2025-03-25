<?php
namespace core;

use Exception;

class Container{
    //service container concept
protected $bindings=[];

public function bind($name ,$resolver){

    $this->bindings[$name]=$resolver;

}

public function resolve($name){

    if(isset($this->bindings[$name]))
    {
        return $this->bindings[$name]($this);
    }
    throw new Exception("Service {$name} not found in container.");

}


}