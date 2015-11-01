<?php


    //Encode result in json format
    function sanitizeResult($result, $code = 200) {
    if (count($result) > 0) {
        sendResponse($code, json_encode($result));
        return true;
    } else {
        sendResponse($code, json_encode("ERROR"));
        return true;
    }
}

    function ReadData() {

    }


function getQueues($conn){
    try
    {

        $tsql = "SELECT [id],[Name],[Location] FROM dbo.Queue";

        echo("Starting Select");
        $getQueues = sqlsrv_query($conn, $tsql);
        if ($getQueues == FALSE) {
            echo("Error!!");
            die(FormatErrors(sqlsrv_errors()));
        }
        $queueCount = 0;
        while($row = sqlsrv_fetch_array($getQueues, SQLSRV_FETCH_ASSOC))
        {
            echo($row['id']." + "$row['Name']." + ".$row['Location']);
            echo("<br/>");
            $queueCount++;
        }
        sqlsrv_free_stmt($getQueues);
        sqlsrv_close($conn);

        echo("Selection done");
        return "YES!!";
    }
    catch(Exception $e)
    {
        echo("Error!");
    }
}
