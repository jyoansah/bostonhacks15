<?php

class User {

    public $id;
    public $queue_id;
    public $queue;
    public $position;


    public function __construct($id, $queue_id, $position) {
        echo "here 4";
        $this->id = $id;
        $this->queue_id = $queue_id;
        $this->position = $position;
        echo "here 5";
    }


    function __toString()
    {
        return $this->getId()." + ".$this->getQueueId()." + ".$this->getPosition()."<br>";
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
    public function getQueueId()
    {
        return $this->queue_id;
    }

    /**
     * @param mixed $queue_id
     */
    public function setQueueId($queue_id)
    {
        $this->queue_id = $queue_id;
    }

    /**
     * @return mixed
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @param mixed $queue
     */
    public function setQueue($queue)
    {
        $this->queue = $queue;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }



}
