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
    <link rel="icon" href="../../favicon.ico">


    <title>Join a Queue!</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="style/cover.css" rel="stylesheet">

<!--    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->-->
<!--    <script src="js/ie10-viewport-bug-workaround.js"></script>-->
</head>
<body>
<div class="site-wrapper">

    <div class="site-wrapper-inner">

        <div class="cover-container">


            <div class="inner cover">

                <?php

                    //Get current customer
                    if (isset($_POST['new_customer']) && isset($_GET['id'])) {
                        echo '<div id="queue_number">';
                        try {
                            $new_user = new User($_GET['id']);
                            $results = addUser($conn, $new_user);
                            $_SESSION['position'] = $results;
                            echo '<h1 class="cover-heading">Your queue number is: ' . $results . '</h1>';
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                        echo '</div>';
                    }

                    if (isset($_GET['id'])) {
                        $firstInLine = getfirstInLine($conn, $_GET['id']);
                        if(!empty($firstInLine)) {
                            echo '<div id="firstInLine">';
                            echo '<h2>Now Serving:</h2>';
                            echo '<h1 class="cover-heading"> ' . $firstInLine . '</h1>';
                            echo '</div>';

                            $lastInLine = getLastInLine($conn, $_GET['id']);

                            echo '<div id="lastInLine">';
                            echo '<h2>There are' . (intval($lastInLine) - intval($firstInLine)) . ' queued</h2>';
                            echo '</div>';
                        }
                        else{
                            echo '<h1 class="cover-heading">Queue is Empty!!</h1>';
                        }

                    }

                    if (isset($_SESSION['position'])) {
                        echo '<div id="position">';
                        echo '<h2>Your current position is:</h2>';
                        echo '<h1 class="cover-heading"> ' . $_SESSION['position'] . '</h1>';
                        echo '</div>';
                    }

                    if (!isset($_POST['new_customer']) && isset($_GET['id'])) {
                        echo '<form method="POST" action="">';
                        echo '<button class="btn btn-lg btn-secondary" name="new_customer" value="submit">Join Queue</button>';
                        echo '</form>';
                    }

                    if (!isset($_POST['new_customer']) && !isset($_GET['id'])) {
                        try {

                            echo '<h1 class="cover-heading">Join a Queue!</h1>';
                            $queues = getqueues($conn);
                            foreach ($queues as $queue) {
                                echo '<p class="lead"><a class="btn btn-lg btn-secondary" href="/customer.php/?id=' . $queue->id . '">' . $queue->name . '</a></p><br>';
                                echo "In: " . $queue->location . " ";
                            }

                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    }
                ?>

        </div>

    </div>

</div>

</div>
</body>
</html>