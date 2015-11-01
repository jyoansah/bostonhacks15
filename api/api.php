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


//                    echo "All Users<br>";
//                    $users = getUsers($this->conn, 39);
//                    foreach($users as &$user){
//                        echo($user);
//                    }

//                    echo "<br>";
//                    echo "<br>";

                    echo "From regular<br>";
                    echo "Type num:".gettype(89);
                    echo getUser($this->conn, 89);
                    echo getUser($this->conn, 100);


                    echo "From getID<br>";

                    $u = new User(39);
                    $u->setId(addUser($this->conn, $u));
                    echo "<br>Type num2: ".gettype($u->getId());
                    echo "<br>Type num3: ".gettype(intval($u->getId()));
                    $tester = intval($u->getId());

                    echo "Tester".$tester;
                    $tester--;

                    echo getUser($this->conn, $tester);
                    echo getUser($this->conn, 89);
//                    echo getUser($this->conn, (int) $inter);




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
