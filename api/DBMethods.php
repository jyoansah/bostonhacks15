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
                $queue = new Queue($row['id'],$row['Name'],$row['Location']);
                $queues[] = $queue;

            }

            sqlsrv_free_stmt($getQueues);

            if (!empty($queues)) {
                return  $queues;
            }else{
                return 'Empty';
            }
        }
        catch(Exception $e)
        {
            echo("Get Queue Error!");
        }
    }

    function getQueue($conn, $id){
        $cond = "id = $id";
        $queues = queueGetter($conn, $cond);

        if (empty($queues)){
            return "not found";
        }
        $ret = $queues[0];
        return $ret;
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



    function userGetter($conn, $condition){
        try
        {

            if($condition == NULL) {
                $tsql = "SELECT [id],[queue_id],[position] FROM dbo.User";
            }
            else{
                $tsql = "SELECT [id],[queue_id],[position] FROM dbo.User WHERE $condition";

            }
            $getUsers = sqlsrv_query($conn, $tsql);
            if ($getUsers == FALSE) {
                echo("Error!!<br>");
                die(print_r( sqlsrv_errors(), true));
            }


            while($row = sqlsrv_fetch_array($getUsers, SQLSRV_FETCH_ASSOC))
            {
                $user = new Queue($row['id'],$row['queue_id'],$row['position']);
                $users[] = $user;

            }

            sqlsrv_free_stmt($getUsers);

            if (!empty($users)) {
                return  $users;
            }else{
                return 'Empty';
            }
        }
        catch(Exception $e)
        {
            echo("Get Queue Error!");
        }
    }

    function getUser($conn, $id){
        $cond = "id = $id";
        $users = queueGetter($conn, $cond);

        if (empty($users)){
            return "not found";
        }
        $ret = $users[0];
        return $ret;
    }

    function getUsers($conn){
        $users = usereGetter($conn, null);
        return $users;
    }


    function addUser($conn, $user){
        $QueueId = $user->getQueueId();
        $Position = $user->getLocation();

        try {
            $tsql = "INSERT INTO dbo.Queue (id, queue_id, position)
                OUTPUT INSERTED.id VALUES (6, '$QueueId','$Position')";
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