<!Doctype html>
<html>
    <head>
        <title>Member Metrics</title>
    </head>
    <body>
        <header>
            <h2><?php getMemberName($_POST['member_id']);?></h2>
            <span id="date"></span>
            <?php
            $now = new DateTime();
            echo $now->format('Y-m-d');
            ?>
        </header>
    </body>
</html>