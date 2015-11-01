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

    function queueGetter($conn, $condition){
        try
        {

            if($condition == NULL) {
                $tsql = "SELECT [id],[Name],[Location] FROM dbo.Queue";
            }
            else{
                $tsql = "SELECT [id],[Name],[Location] FROM dbo.Queue WHERE $condition";

            }
            $getQueues = sqlsrv_query($conn, $tsql);
            if ($getQueues == FALSE) {
                echo("Error!!<br>");
                die(print_r( sqlsrv_errors(), true));
            }


            while($row = sqlsrv_fetch_array($getQueues, SQLSRV_FETCH_ASSOC))
            {
                echo("here 1");
                $queue = new Queue($row['id'],$row['Name'],$row['Location']);
                $queues[] = $queue;

            }

            echo("here 2<br>$queues[1]");
            sqlsrv_free_stmt($getQueues);

            if (!empty($queues)) {
                return  $queues;
            }else{
                return ' ';
            }
        }
        catch(Exception $e)
        {
            echo("Get Queue Error!");
        }
    }

    function getQueue($conn, $id){
        $cond = "id = $id";
        echo("herexx");
        $queues = queueGetter($conn, $cond);
        echo("here3");

        if (empty($queues)){
            return "not found";
        }
        return $queues[1];
    }

    function getQueues($conn){
        $queues = queueGetter($conn, null);
        return $queues;
    }


    function addQueue($conn, $queue){
        $Name = $queue->getName();
        $Location = $queue->getLocation();

        try {
            $tsql = "INSERT INTO dbo.Queue (id, Name, Location)
            OUTPUT INSERTED.id VALUES (6, '$Name','$Location')";
            //Insert query
            $insertReview = sqlsrv_query($conn, $tsql);

            if ($insertReview == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }

            echo "Product Key inserted is :";

            while($row = sqlsrv_fetch_array($insertReview, SQLSRV_FETCH_ASSOC))
            {
                echo($row['id']);
            }
            sqlsrv_free_stmt($insertReview);
            sqlsrv_close($conn);
        }
        catch(Exception $e)
        {
            echo("Add Queue Error!");
        }

    }