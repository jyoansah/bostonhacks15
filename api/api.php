<?php

include_once 'controller.php';
error_reporting(E_ALL);

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

//                    $q = new Queue("TestQueue2", "Test Location2<br>");
//                    $q->setId(addQueue($this->conn, $q));
//                    echo "New Queue Created: ".getQueue($this->conn, $q->getId())."<br>";

                    $u = new User(39);
                    echo "New User Created at position: ".addUser($this->conn, $u)."<br>";

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

$action = $_REQUEST['q'];
$api = new api();
