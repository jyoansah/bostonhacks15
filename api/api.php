<?php

include_once 'controller.php';

class api {

    public $conn;

    // Constructor - open DB connection
    function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Destructor - close DB connection
    function __destruct() {
        $this->conn = null;
    }
    
    // API interface
    function api($action = null, $msg = null) {

        if ((isset($action) && isset($msg)) || isset($action)) {
            
            //NQAssertSession();
            switch ($action) {
                case API_CALL:
                        echo "This is a test api call<br/>";
                    break;

                case DB_METHODS:
                    echo "This is a test api call\n\n";
                    $queues = getQueues($this->conn);
                    echo("Here");
                    foreach($queues as &$queue){
                        echo("Here");
                        echo($queue->getName()." + ".$queue->getLocation()."\n");
                    }
                    break;

                //Aux command calls
                case SET_FEEDBACK_MSG:
                    setFeedbackMessage($msg);
                    break;

                default : sanitizeResult('Invalid Action', 400);
                    break;
            }
        } else {
            sanitizeResult('Invalid Request', 400);
            echo "Bad Call. Boohoo";
        }
    }

}

$api = new api();
