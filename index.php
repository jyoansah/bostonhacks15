<!DOCTYPE html>
<?php 
 header("access-control-allow-origin: *");
 include_once 'api/api.php';
 global $conn, $api;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>I hate queues!</title>

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <p class="text-center"><h1>deeque</h1></p>
            <p class="text-center"><h3>Do you hate waiting in line? We do too!</h3></p>
            <?php
              $api->api(DB_METHODS);
            ?>
            <br>
            <br>
            Are you a <a href="customer.php">customer</a> or a <a href="restaurant.php">restaurant</a>
        </div>
    </body>
</html>
