<html>
    <head>
        <title>User Sign Up</title>
        <link href="index.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <h2>Please enter sign up details:</h2>
        <form action="/metricsPage.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name"><br>
            <label for="address">Address Line 1:</label>
            <input type="text" name="address"><br>
            <label for="city">City:</label>
            <input type="text" width="50px" name="city"><br>
            <input type="submit" name="submit" value="Sign Up!">
        </form>
    </body>
</html>