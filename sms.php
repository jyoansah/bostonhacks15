<?php
    header("access-control-allow-origin: *");
    include_once 'api/api.php';
    global $conn, $api;
    session_start();
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>



<Response>
    <Message>Hello, Welcome to Deeque </br>
    Please select a Queue:<br>
        <?php
            $queues = getQueues($conn);
            foreach ($queues as $queue) {
                echo $queue->id.' --> '.$queue->name.'</br>';
            }
        ?>
    </Message>
</Response>