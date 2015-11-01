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
                        testFunction($conn);
                        testFunction($this->conn);
                        testFunction(OpenConnection());
                        //createSampleTable(OpenConnection());
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
