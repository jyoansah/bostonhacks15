<!DOCTYPE html>
<head>
    <title>
        I hate queues!
    </title>
</head>
<body>
    Do you hate queues? We do too!


    <?php

    function OpenConnection()
    {

        ehco("starting!");
        try
        {
            $serverName = "tcp:c3185u2dmj.database.windows.net,1433";
            $connectionOptions = array("Database"=>"deeque",
                "Uid"=>"deeque", "PWD"=>"ASdf1234");
            $conn = sqlsrv_connect($serverName, $connectionOptions);
            if($conn == false)
                die(FormatErrors(sqlsrv_errors()));
        }
        catch(Exception $e)
        {
            echo("Error!");
        }

        ehco("connected!");
    }

    OpenConnection();

    ?>

</body>
</html>
