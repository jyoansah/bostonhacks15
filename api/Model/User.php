<?php

class User {

    public $id;
    public $queue_id;
    public $queue;
    public $position;
    public $tel;



    public function newUser($id, $queue_id, $position) {
        $this->id = $id;
        $this->queue_id = $queue_id;
        $this->position = $position;
    }

    public function __construct($queue_id){
        $this->queue_id = $queue_id;
    }


    function __toString()
    {
        return "UserId: ".$this->getId()." QueueId: ".$this->getQueueId()." Position: ".$this->getPosition()."<br>";
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

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }




}
