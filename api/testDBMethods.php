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
    function Select($param, $table) {

        $tsql = "SELECT $param FROM dbo.$table";
        $data = sqlsrv_query($this->conn, $tsql);

        if ($data == FALSE) {
            echo("Error!!");
            die(FormatErrors(sqlsrv_errors()));
        }

        $array = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC);

        sqlsrv_free_stmt($data);
        sqlsrv_close($this->conn);

        return $array;
    }

    function getQueues()
    {
        $getQueues = Select('Name', 'Queue');
        while ($row = sqlsrv_fetch_array($getQueues, SQLSRV_FETCH_ASSOC)) {
            $queueCount = 0;
            while ($row = sqlsrv_fetch_array($getQueues, SQLSRV_FETCH_ASSOC)) {
                echo("<br/>");
                echo($row['Name']);
                echo("<br/>");
                $queueCount++;
            }
        }
    }


    //Inserts row in table
    function Insert($conn, $searchBy, $table) {
        $param = NQMultiplePreProcessor($searchBy);
        $sql = "INSERT INTO $table $param";
        $stmt = $conn->prepare($sql);
        NQBasicBindParamPreProcessor($stmt, $searchBy, true);

        return $stmt;
    }

