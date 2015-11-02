<!DOCTYPE html>
<?php
header("access-control-allow-origin: *");
include_once 'api/api.php';
global $conn, $api;
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


        <title>I hate queues!</title>

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <!-- Custom styles for this template -->
        <link href="style/cover.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="js/ie10-viewport-bug-workaround.js"></script>

    </head>


    <body>
        <div class="site-wrapper">

            <div class="site-wrapper-inner">

                <div class="cover-container">
                    

                    <div class="inner cover">
                        <h1 class="cover-heading">deeque</h1>

                        <p class="lead">Do you hate waiting in line? We do too!</p>

                        <p class="lead">
                            <a href="customer.php" class="btn btn-lg btn-secondary">Customer</a>
                            <a href="restaurant.php" class="btn btn-lg btn-secondary">Restaurant</a>
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </body>
</html>