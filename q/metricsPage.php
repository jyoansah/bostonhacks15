<!Doctype html>
<html>
    <head>
        <title>Member Metrics</title>
    </head>
    <body>
        <header>
            <h2>Member Name</h2>
            <span id="date">
            <?php
            $now = new DateTime();
            echo $now->format('Y-m-d');
            ?>
            </span>
        </header>
    </body>
</html>