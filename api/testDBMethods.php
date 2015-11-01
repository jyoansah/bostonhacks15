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


    //Default selects everything in table
    function Select($conn, $param, $table) {

        $tsql = "SELECT [$param] FROM dbo.$table";
        $data = sqlsrv_query($conn, $tsql);

        if ($data == FALSE) {
            echo("Error!!");
            die(FormatErrors(sqlsrv_errors()));
        }

        $array = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC);

        sqlsrv_free_stmt($data);
        sqlsrv_close($conn);

        return $array;
    }

    function getQueues($conn)
    {
        $getQueues = Select($conn, 'Name', 'Queue');
        $queueCount = 0;
        while ($getQueues) {

                echo("<br/>");
                echo($getQueues['Name']);
                echo("<br/>");
                $queueCount++;
        }

        return "Yes!";
    }


    //Inserts row in table
    function Insert($conn, $searchBy, $table) {
        $param = NQMultiplePreProcessor($searchBy);
        $sql = "INSERT INTO $table $param";
        $stmt = $conn->prepare($sql);
        NQBasicBindParamPreProcessor($stmt, $searchBy, true);

        return $stmt;
    }

