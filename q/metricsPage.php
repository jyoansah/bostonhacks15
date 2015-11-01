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
        <p>Current Customer: #6</p>
        <form action="$_SERVER['PHP_SELF']" method="post">
            <input type="submit" value="Next" name="submit">
        </form>
    </body>
</html>