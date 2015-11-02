<?php
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    header("access-control-allow-origin: *");
    include_once 'api/api.php';
    global $conn, $body, $joined, $api;
    session_start();

    if (isset($_REQUEST['Body'])) {
        $body = $_REQUEST['Body'];
        $token = strtok($body, " ");
        if (strtolower($token) == 'join') {
            $token = strtok(" ");
            $user = new User(intval($token));
            $user->setTel($_REQUEST['From']);
            $joined = addUserDB($conn, $user);
        }
    }
?>

<Response>
    <Message>
        <?php
        if (empty($joined)) {
            echo "Hello, Welcome to Deeque! Please select a Queue: \n";
            $queues = getQueues($conn);
            foreach ($queues as $queue) {
                echo $queue->id . " --> " . $queue->name . "\n";
            }
        } else {
            echo "You joined : ".$joined['queue'].". You are number: ".$joined['position'].
                ". Now serving: ".$joined['serving'];
        }
        ?>
    </Message>
</Response>