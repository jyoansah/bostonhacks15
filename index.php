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
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>
        <div id="container">
            <h1>deeque</h1>
            Do you hate queues? We do too!
            <?php
              $api->api(DB_METHODS);
            ?>
            Are you a <a href="customer.php">customer</a> or a <a href="restaurant.php">restaurant</a>
        </div>
    </body>
</html>
