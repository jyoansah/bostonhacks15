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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="/style/cover.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>

</head>
<body>
<div class="site-wrapper">

    <div class="site-wrapper-inner">

        <div class="cover-container">


            <div class="inner cover">


                <div class="cust>">
                    <?php


                    //Get current customer
                    if (isset($_POST['new_customer']) && isset($_GET['id'])) {
                        echo "here1";
                        try {
                            $new_user = new User($_GET['id']);
                            $results = addUser($conn, $new_user);
                            $_SESSION['position'] = $results['position'];
                            $_SESSION['curr_queue'] = $results['queue'];
                            echo '<h1 class="cover-heading"> Queue Joined</h1>';
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    }

                    //User has a positon
                    if (isset($_SESSION['position'])) {
                        echo "here2";

                        //clear user after serving
                        $firstInLine = getfirstInLine($conn, $_GET['id']);
                        if ($firstInLine > $_SESSION['position']) {
                            unset($_SESSION['position']);
                        } else {
                            // Always Show user Position
                            echo '<div id="position">';
                            echo '<h3>Your current position is:</h3>';
                            echo '<h1 class="cover-heading"> ' . $_SESSION['position'] . '</h1>';
                            echo '<h3 > In Queue "' . $_SESSION['curr_queue'] . '"</h3>';
                            echo '</div>';
                        }
                    }

                    ?>
                </div>

                <div class="que">
                    <?php
                    if (isset($_GET['id'])) {
                        echo "here30";

                        $queue_sel = getQueue($conn, intval($_GET['id']));
                        echo '<h1 class="que-heading">"' . $queue_sel->getName() . '"</h1>';

                        $firstInLine = getfirstInLine($conn, $_GET['id']);

                        if (!empty($firstInLine)) {

                            $lastInLine = getLastInLine($conn, $_GET['id']);

                            $length = (intval($lastInLine) - intval($firstInLine) + 1);

                            if ($length > 1) {
                                echo '<h2>There are ' . $length . ' people queued</h2>';
                            } elseif ($length == 1) {
                                echo '<h2>There is ' . $length . ' person queued</h2>';
                            }

                        } else {
                            echo '<h1 class="cover-heading">Queue is Empty!!</h1>';
                        }

                    }

                    if (!isset($_POST['new_customer']) && isset($_GET['id']) && !isset($_SESSION['position'])) {
                        echo "here4";
                        echo '<form method="POST" action="">';
                        echo '<button class="btn btn-lg btn-secondary" name="new_customer" value="submit">Join Queue</button>';
                        echo '</form>';
                    }

                    if (!isset($_POST['new_customer']) && !isset($_GET['id']) &&!isset($_SESSION['position'])) {
                        echo "here5";
                        try {

                            echo '<h1 class="cover-heading">Join a Queue!</h1>';
                            $queues = getqueues($conn);
                            foreach ($queues as $queue) {
                                echo '<p class="lead"><a class="btn btn-lg btn-secondary" href="/customer.php/?id=' . $queue->id . '">' . $queue->name . '
                                <span>In ' . $queue->location . '</span></a></p><br>';
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