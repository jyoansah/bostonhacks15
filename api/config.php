<?php
    define("HOST", "c3185u2dmj.database.windows.net");
    define("USER", "deeque");
    define("PORT", "1433");
    define("PASSWORD", "ASdf1234");
    define("DATABASE", "deeque");
    define("SECURE", FALSE);
    define("BASE_DIR", "");
    define("BASE_URL", "");

    function OpenConnection(){
        $error = "";
        $dbhost = HOST;
        $dbuser = USER;
        $dbport = PORT;
        $dbpass = PASSWORD;
        $dbname = DATABASE;
        $serverName = "tcp:$dbhost,$dbport";

        try {
            $connectionOptions = array("Database"=>"$dbname", "Uid"=>"$dbuser", "PWD"=>"$dbpass");
            $conn = sqlsrv_connect($serverName, $connectionOptions);
            if ($conn == false) {
                die(FormatErrors(sqlsrv_errors()));
            }
        } catch(Exception $e){
            echo("Error!");
            $error = $e->getMessage();
        }
    }

    $conn = OpenConnection();