<?php
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    header("access-control-allow-origin: *");
    include_once 'api/api.php';
    global $conn, $body, $position, $api;
    session_start();

    if(isset($_REQUEST['Body'])){
        $body =  $_REQUEST['Body'];

        $token = strtok($body, " ");

        if ($token == 'join' || $token == 'Join'){
            echo "here";
            $token = strtok($body, " ");
            $user = new User(intval($token));
            $user->setTel( $_REQUEST['From']);
            $position = addUser($conn, $user);
        }
    }
?>


<Response>
    <Message>Hello, Welcome to Deeque
    Please select a Queue:
        <?php
            echo "You are num:".$position;
            $queues = getQueues($conn);
            foreach ($queues as $queue) {
                echo $queue->id." --> ".$queue->name."\n";
            }
        ?>
    </Message>
</Response>