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
        <link rel="stylesheet" type="text/css" href="style/index.css">
    </head>
    <body>
        Do you hate queues? We do too!
        <?php
          $api->api(API_CALL);
        ?>
        Are you a <a href="customer.php">customer</a> or a <a href="restaurant.php">restaurant</a>
    </body>
</html>
