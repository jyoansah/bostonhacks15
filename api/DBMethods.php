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

    function getQueues($conn, $condition){
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
            echo("Error!");
        }
    }

    function getQueue($conn, $id){
        $cond = "id = $id";
        $queue = getQueues($conn, $cond)[1];
    }
