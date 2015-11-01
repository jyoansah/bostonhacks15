<?php
    header("access-control-allow-origin: *");
    include_once 'api/api.php';
    global $conn, $body, $position, $api;
    session_start();
?>


<Response>
    <Message>Hello, Welcome to Deeque
    Please select a Queue:
        <?php
            echo "Here0";

        if(isset($_REQUEST['Body'])){
            echo "Here1";
                $body =  $_REQUEST['Body'];

                $token = strtok($body, " ");
                echo "Here".$token;

                if (strtolower($token) == 'join'){
                    echo "Here2";
                    $token = strtok(" ");
                    $user = new User(intval($token));
                    $user->setTel( $_REQUEST['From']);
                    $position = "You are num: ".$position.addUser($conn, $user);
                }
            }
            if(!empty($position)) {
                echo  $position;
            }
            else{
                $queues = getQueues($conn);
                foreach ($queues as $queue) {
                    echo $queue->id . " --> " . $queue->name . "\n";
                }
            }
        ?>
    </Message>
</Response>