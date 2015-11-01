<?php

class Queue {
    
    public $id;
    public $name;
    public $location;
    public $eta;

    public function __construct($name, $location) {
        $this->name = $name;
        $this->location = $location;
    }
    
    public function getAllQueues(){
        
    }

}
