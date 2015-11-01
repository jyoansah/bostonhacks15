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
          //$api->api(API_CALL);
        ?>
    </body>
</html>
