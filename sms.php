<?php
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
header("access-control-allow-origin: *");
include_once 'api/api.php';
global $conn, $api;
?>

<?php
function listQs()
{
    $queues = getqueues($this->conn);
    foreach ($queues as $queue) {
        echo 'Queue ID: ' . $queue->id . ' --> ' . $queue->name . '<br>';
        //echo '<a href="restaurant.php/?id='.$queue["id"].'">'."sup".$queue['name'].'</a>"';
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