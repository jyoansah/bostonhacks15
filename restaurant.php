<!DOCTYPE html>
<?php
header("access-control-allow-origin: *");
include_once 'api/api.php';
global $conn, $api;
session_start();
?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/../../favicon.ico">


    <title>Restaurant Control Panel</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="style/cover.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
</head>
<body>

    <nav class="navbar navbar-default navbar-static-top">
        <a href="/index.php" class="navbar-brand">DeeQue</a>
    </nav>

    <div class="site-wrapper">

        <div class="site-wrapper-inner">

            <div class="cover-container">

<?php

    if (!isset($_GET['qid'])) {
        $queues = getqueues($conn);

        echo '<h1 >Manage your Queues:</h1>';

        foreach ($queues as $queue) {
            echo '<p class="lead"><a class="btn btn-lg btn-secondary" href="/restaurant.php/?qid=' . $queue->id . '">' . $queue->name . '
                                            <span>in ' . $queue->location . '</span></a></p>';
        }

    }
    //Get current customer
    if (isset($_POST['next_customer'])) {
        try {
            deQueueUser($conn, $_SESSION['qid']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    if (isset($_GET['qid'])) {
        $_SESSION['qid'] = $_GET['qid'];

        //Get list of all people in the queue
        $queue_users = getUsers($conn, $_SESSION['qid']);
        // foreach($queue_users as $queue_user){

        ?>
        <div class="table">
                <?php
                if (!empty($queue_users)) {

                    try {

                       $current_position = getfirstInLine($conn, $_SESSION['qid']);

                        echo '<h1>Now serving: ' . $current_position . '</h1>';
                        echo '<form method="POST" action="">';
                        echo '<button class="btn btn-lg btn-secondary" name="next_customer" value="submit">Next customer</button>';
                        echo '</form>';

                    } catch (Exception $e) {
                        echo "<br>" . $e->getMessage();
                    }
                    echo '<div class="draw">';
                    foreach ($queue_users as $queue_user) {
                        ?>

                            <i class="fa fa-user fa-3x"></i>

                    <?php }

                    echo '</div>';
                }else{
                    echo '<h1>Queue Empty!</h1>';
                } ?>

        </div>
        <?php
        // }


    }


    ?>

                </div>
            </div>
        </div>

</body>
</html>