<?php

class Queue {

    public $id;
    public $name;
    public $location;
    public $eta;


    public function newQueue($id, $queue_id, $position) {
        $this->id = $id;
        $this->queue_id = $queue_id;
        $this->position = $position;
    }

    public function __construct($name, $location) {
        $this->name = $name;
        $this->location = $location;
    }


    function __toString()
    {
        return "QueueId: ".$this->getId()." Name: ".$this->getName()." Position: ".$this->getLocation()."<br>";

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getEta()
    {
        return $this->eta;
    }

    /**
     * @param mixed $eta
     */
    public function setEta($eta)
    {
        $this->eta = $eta;
    }


}
