<?php
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    header("access-control-allow-origin: *");
    include_once 'api/api.php';
    global $conn, $body, $api;
    session_start();

    if(isset($_REQUEST['Body'])){
        $body =  $_REQUEST['Body'];

        $tokens = strtok($body, " ");

        if ($body[0] == 'join' || $body[0] == 'Join'){
            $user = new User(intval($body[1]));
            $user->setTel( $_REQUEST['From']);
            addUser($conn, $user);
        }
    }
?>


<Response>
    <Message>Hello, Welcome to Deeque
    Please select a Queue:
        <?php
            echo $body;
            $queues = getQueues($conn);
            foreach ($queues as $queue) {
                echo $queue->id." --> ".$queue->name."\n";
            }
        ?>
    </Message>
</Response>