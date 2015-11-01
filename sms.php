<?php
header("access-control-allow-origin: *");
include_once 'api/api.php';
global $conn, $api;
session_start();
?>



<Response>
    <Sms>Hello, Welcome to Deeque<br>
    Please select a 2queue:
        <?php
            $queues = getqueues($this->conn);
            foreach ($queues as $queue) {
                echo 'Queue ID: '.$queue->getId().' --> '.$queue->getName().'<br>';
            }
        ?>
    </Sms>
</Response>