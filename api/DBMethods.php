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

            if($condition == NULL)

                $tsql = "SELECT [id],[Name],[Location] FROM dbo.Queue";

            else{
                $tsql = "SELECT [id],[Name],[Location] FROM dbo.Queue WHERE $condition";

            }

            $getQueues = sqlsrv_query($conn, $tsql);
            if ($getQueues == FALSE) {
                echo("Error!!");
                die(FormatErrors(sqlsrv_errors()));
            }



            while($row = sqlsrv_fetch_array($getQueues, SQLSRV_FETCH_ASSOC))
            {

                $queue = new Queue($row['id'],$row['Name'],$row['Location']);
                $queues[] = $queue;

            }

            sqlsrv_free_stmt($getQueues);
//            sqlsrv_close($conn);

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
        $cond = "id = '$id''";
        $queues = queueGetter($conn, $cond);

        return $queues[1];
    }

    function getQueues($conn){
        $queues = queueGetter($conn, null);
        return $queues;
    }


    function addQueue($conn, $queue){

        $Name = $queue->getName();
        $Location = $queue->getLocation();

        try
        {
            echo("here 111");
            $tsql = "INSERT INTO dbo.Users (queue_id, queue_location)
            OUTPUT INSERTED.id VALUES ('$Name', '$Location')";
            //Insert query
            $insertReview = sqlsrv_query($conn, $tsql);

            echo("here 222");
            if($insertReview == FALSE)
                die(FormatErrors( sqlsrv_errors()));
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