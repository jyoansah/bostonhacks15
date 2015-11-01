<?php
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        header("access-control-allow-origin: *");
        include_once 'api/api.php';
        global $conn, $api;

        function listQs()
        {
            $queues = getqueues($this->conn);
            foreach ($queues as $queue) {
                echo 'Queue ID: ' . $queue->id . ' --> ' . $queue->name . '<br>';
            }
        }
?>

<Response>
    <Message>Hello, Welcome to Deeque<br>
    Please select a queue:
        <?php
            listQs();
        ?>
    </Message>
</Response>