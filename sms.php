<?php
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        header("access-control-allow-origin: *");
        include_once 'api/api.php';
        global $conn, $api;

        function listQs()
        {
            $ret = "";
            $queues = getqueues($this->conn);
            foreach ($queues as $queue) {
                $ret =  $ret.'Queue ID: ' . $queue->id . ' --> ' . $queue->name . '<br>';
            }

            return $ret;
        }
?>

<Response>
    <Sms>Hello, Welcome to Deeque<br>
    Please select a queue:
        <?php
            echo listQs();
        ?>
    </Sms>
</Response>