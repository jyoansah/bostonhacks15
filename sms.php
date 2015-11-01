<?php
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    header("access-control-allow-origin: *");
    include_once 'api/api.php';
    global $conn, $api;
    session_start();
?>


<Response>
    <Message>Hello, Welcome to Deeque
    Please select a Queue:
        <?php
            $queues = getQueues($conn);
            foreach ($queues as $queue) {
                echo $queue->id.' --> '.$queue->name.'\n';
            }
        ?>
    </Message>
</Response>