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

    function queueGetter($condition){
        try
        {

            if($condition == NULL) {
                $tsql = "SELECT [id],[Name],[Location] FROM dbo.Queue";
            }
            else{
                $tsql = "SELECT [id],[Name],[Location] FROM dbo.Queue WHERE $condition";

            }
            $getQueues = sqlsrv_query($this->conn, $tsql);
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

    function getQueue($id){
        $cond = "id = $id";
        $queues = queueGetter($cond);

        if (empty($queues)){
            return "not found";
        }

        return $queues[0];
    }

    function getQueues(){
        $queues = queueGetter(null);
        return $queues;
    }

    function addQueue($queue){
        $Name = $queue->getName();
        $Location = $queue->getLocation();

        try {
            $tsql = "INSERT INTO dbo.Queue ( Name, Location)
            OUTPUT INSERTED.id VALUES ('$Name','$Location')";
            //Insert query
            $insertReview = sqlsrv_query($conn, $tsql);

            if ($insertReview == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }

            echo "Product Key inserted is :";

            while($row = sqlsrv_fetch_array($insertReview, SQLSRV_FETCH_ASSOC))
            {
                $new_id = $row['id'];
            }
            sqlsrv_free_stmt($insertReview);
            sqlsrv_close($conn);
        }
        catch(Exception $e)
        {
            echo("Add Queue Error!");
        }

        if (empty($new_id)){
            return "not found";
        }
        return $new_id;

    }



    function userGetter($condition){
        try
        {
            if($condition == NULL) {
                $tsql = "SELECT [id],[queue_id],[position] FROM dbo.Users";
            }
            else{
                $tsql = "SELECT [id],[queue_id],[position] FROM dbo.Users WHERE $condition";

            }
            var_dump($this->conn);
            $getUsers = sqlsrv_query($this->conn, $tsql);
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

    function getUser( $id){
        $cond = "id = $id";
        $users = queueGetter( $cond);

        if (empty($users)){
            return null;
        }

        return $users[0];
    }

    function getUsers(){
        $users = userGetter( null);
        return $users;
    }

    function addUser($user){
        $QueueId = $user->getQueueId();
        $Position = $user->getLocation();

        try {
            $tsql = "INSERT INTO dbo.Queue (queue_id, position)
                OUTPUT INSERTED.id VALUES ('$QueueId','$Position')";
            //Insert query
            $insertReview = sqlsrv_query($this->conn, $tsql);

            if ($insertReview == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }

            echo "Product Key inserted is :";

            while($row = sqlsrv_fetch_array($insertReview, SQLSRV_FETCH_ASSOC))
            {
                $new_id = $row['id'];
            }
            sqlsrv_free_stmt($insertReview);
            sqlsrv_close($conn);
        }
        catch(Exception $e)
        {
            echo("Add Queue Error!");
        }
        if (empty($new_id)){
            return null;
        }else{
            return $new_id;
        }


    }


    function getUsersForQueue(){

    }