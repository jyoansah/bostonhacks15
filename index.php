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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="container">
            <p class="text-center"><h1>deeque</h1></p>
            <p class="text-center"><h3>Do you hate waiting in line? We do too!</h3></p>
            <?php
              $api->api(DB_METHODS);
            ?>
            Are you a <a href="customer.php">customer</a> or a <a href="restaurant.php">restaurant</a>
        </div>
    </body>
</html>
