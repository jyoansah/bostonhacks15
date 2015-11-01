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
                    echo "This is a test api call<br><br>";

//
//                    echo "Get Users<br>";
//                    $users = getUsers($this->conn);
//                    foreach($users as &$user){
//                        echo($user);
//                    }
//
//
//                    echo "Add Queue<br>";
//
//                    $q = new Queue(0, 'Test3', 'A location');
//                    $q->setId(addQueue($this->conn, $q));
//
//                    echo getQueue($this->conn, $q->getId());


                    echo "Add User<br>";
                    $u = new User('1', '5', '8');
                    echo addUser($this->conn, $u);

                    $u->setId();

                    echo getUser($this->conn, $u->getId());




//                    echo "get queues<br>";
//
//                    $queues = getQueues($this->conn);
//                    foreach($queues as &$queue){
//                        echo($queue);
//                    }
//
////                    echo("<br>");
////                    echo("<br>");
////                    echo "Add queues<br>";
////
////                    $q = new Queue(0, 'Test3', 'A location');
////                    echo($q);
////                    addQueue($this->conn, $q);
//
//                    echo("<br>");
//                    echo("<br>");
//
//                    echo "Get 1 Queue<br>";
//                    $queue1 = getQueue($this->conn, 1);
//                    echo($queue1);

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
