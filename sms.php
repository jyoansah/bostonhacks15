<?php
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    header("access-control-allow-origin: *");
    include_once 'api/api.php';
    global $conn, $body, $position, $api;
    session_start();

    if (isset($_REQUEST['Body'])) {
        $body = $_REQUEST['Body'];
        $token = strtok($body, " ");
        if (strtolower($token) == 'join') {
            $position = 1;
            $token = strtok(" ");
            $user = new User(intval($token));
            $user->setTel($_REQUEST['From']);
            $position = intval(addUser($conn, $user));
        }
    }
?>

<Response>
    <Message>Hello, Welcome to Deeque
        <?php
        if (empty($position)) {
            echo "$Please select a Queue: \n";
            $queues = getQueues($conn);
            foreach ($queues as $queue) {
                echo $queue->id . " --> " . $queue->name . "\n";
            }
        } else {
            echo "You are num: 48. Now serving 27";
        }
        ?>
    </Message>
</Response>