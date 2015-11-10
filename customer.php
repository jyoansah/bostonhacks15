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


    <title>Join a Queue!</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="/style/cover.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>

</head>
<body>

<nav class="navbar navbar-default navbar-static-top">
    <a href="/index.php" class="navbar-brand">DeeQue</a>
</nav>

<div class="site-wrapper">

    <div class="site-wrapper-inner">

        <div class="cover-container">


            <div class="inner cover">


                <div class="cust>">
                    <?php

//                    echo 'cusPostion: ' . $_SESSION['position'];

                    //Add customer to queue
                    if (isset($_POST['new_customer']) && isset($_GET['id'])) {
                        try {
                            $new_user = new User($_GET['id']);
                            $results = addUser($conn, $new_user);
                            $_SESSION['position'] = $results['position'];
                            $_SESSION['curr_queue'] = $results['queue'];
                            $_SESSION['queue_id'] = $results['queue_id'];
                            echo '<h1 class="cover-heading"> Queue Joined</h1>';
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    }

                    //User has a positon
                    if (isset($_SESSION['position'])) {

                        //Get first in line:
                        $firstInLine = getfirstInLine($conn, $_SESSION['queue_id']);

//                        echo "<br>cusfil:" . $firstInLine;
//                        echo "<br>cuspos:" . $_SESSION['position'];

                        //Clear if served
                        if ($firstInLine > $_SESSION['position'] || empty($firstInLine)) {
                            unset($_SESSION['position']);
                            unset($_SESSION['curr_queue']);
                            unset($_SESSION['queue_id']);
                        } //If user is front of line
                        elseif ($firstInLine == $_SESSION['position']) {
                            echo '<div id="position">';
                            echo '<h3>You\'re up!. Head to the front of:</h3>';
                            echo '<h3 >' . $_SESSION['curr_queue'] . '</h3>';
                            echo '</div>';
                        } //if user is not in front of line.
                        else {
                            echo '<div id="position">';
                            echo '<h3>Your number is:</h3>';
                            echo '<h1 class="cover-heading"> ' . $_SESSION['position'] . '</h1>';
                            echo '<h4 > In queue "' . $_SESSION['curr_queue'] . '"</h4>';
                            echo '</div>';
                        }
                    }


                    //Queue currently selected
                    if (isset($_GET['id'])) {


                        $queue_sel = getQueue($conn, intval($_GET['id']));

                        $firstInLine = getfirstInLine($conn, $_GET['id']);

                        if (!empty($firstInLine)) {

                            $lastInLine = getLastInLine($conn, $_GET['id']);

                            $length = (intval($lastInLine) - intval($firstInLine));

//                            echo "len".$length;

                            if (isset($_SESSION['position'])) {
                                if ($length > 1) {
                                    echo '<h4>There are ' . $length . ' people ahead of you.</h4>';
                                } elseif ($length == 1) {
                                    echo '<h4>There is ' . $length . ' person ahead of you</h4>';
                                }

                                echo '<div class="draw">';
                                for($x = 0; $x <= $length; $x++) {

                                    echo '<i class="fa fa-user fa-3x" ></i >';

                                }
                                echo '</div>';

                            } else {
                                echo '<h1 class="que-heading">"' . $queue_sel->getName() . '"</h1>';
                                if ($length > 0) {
                                    echo '<h4>There are ' . ($length+1) . ' people in the queue.</h4>';
                                } elseif ($length == 0) {
                                    echo '<h4>There is ' . ($length+1) . ' person in the queue.</h4>';
                                }
                            }


                        } else {
                            echo '<h1 class="cover-heading">Queue is Empty!!</h1>';
                        }

                    }

                    ?>
                </div>

                <div class="que">
                    <?php


                    if (!isset($_POST['new_customer']) && isset($_GET['id']) && !isset($_SESSION['position'])) {
                        echo '<form method="POST" action="">';
                        echo '<button class="btn btn-lg btn-secondary" name="new_customer" value="submit">Join Queue</button>';
                        echo '</form>';

                        echo '<br><br><a href="customer.php"><button class="btn btn-sm btn-secondary">Back to Queues</button></a>';
                    }

                    if (!isset($_POST['new_customer']) && !isset($_GET['id']) && !isset($_SESSION['position'])) {
                        try {

                            echo '<h1 class="cover-heading">Join a Queue!</h1>';
                            $queues = getqueues($conn);
                            foreach ($queues as $queue) {
                                echo '<p class="lead"><a class="btn btn-lg btn-secondary" href="/customer.php/?id=' . $queue->id . '">' . $queue->name . '
                                <span>in ' . $queue->location . '</span></a></p>';
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

</div>
</body>
</html>