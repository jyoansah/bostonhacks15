<?php
    header("access-control-allow-origin: *");
    include_once 'api/api.php';
    global $conn, $api;
    session_start();
?>



<Response>
    <Sms>Hello, Welcome to Deeque<br>
    Please select a Queue:<br>
        <?php
            $queues = getQueues($conn);
            foreach ($queues as $queue) {
                echo $queue->id.' --> '.$queue->name.'<br>';
            }
        ?>
    </Sms>
</Response>