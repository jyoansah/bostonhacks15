<?php
header("access-control-allow-origin: *");
include_once 'api/api.php';
global $conn, $api;
session_start();
?>



<Response>
    <Sms>Hello, Welcome to Deeque<br>
    Please select a 3queue:
        <?php
            echo 'here';
            $queues = getqueues($this->conn);
            echo 'here1'
            foreach ($queues as $queue) {
                echo 'here2';
                echo 'Queue ID: '.$queue->getId().' --> '.$queue->getName().'<br>';
            }
        ?>
    </Sms>
</Response>