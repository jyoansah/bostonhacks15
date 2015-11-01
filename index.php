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
    </head>
    <body>
        Do you hate queues? We do too!
        <?php
          $api->api(DB_METHODS);
        ?>
        Are you a <a href="customer.php">customer</a> or a <a href="restaurant.php">restaurant</a>
    </body>
</html>
