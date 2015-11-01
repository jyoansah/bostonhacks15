<?php
    header("access-control-allow-origin: *");
    include_once 'api/api.php';
    global $conn, $body, $position, $api;
    session_start();

    if(isset($_REQUEST['Body'])){
        $body =  $_REQUEST['Body'];

        $token = strtok($body, " ");

        if (strtolower($token) == 'join'){
            $position = "You are num: ";
            $token = strtok(" ");
            $user = new User(intval($token));
            $user->setTel( $_REQUEST['From']);
            $position = $position.addUser($conn, $user);
        }
    }
?>


<Response>
    <Message>Hello, Welcome to Deeque
    Please select a Queue:
        <?php
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