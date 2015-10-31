<?php

    function OpenConnection()
    {

        echo("starting!");
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

        echo("connected!");
    }
?>