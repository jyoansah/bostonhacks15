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

    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6) {
            $theValue_ = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }
        switch ($theType) {
            case "text":
                $theValue_ = ($theValue != "") ? $theValue : "NULL";
                break;
            case "long":
            case "int":
                $theValue_ = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue_ = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue_ = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue_ = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue_;
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
        $cond = "id =".intval($id);
        $queues = queueGetter($conn, $cond);

        if (empty($queues)){
            return "not found";
        }
        return $queues[0];
    }

    function getQueues($conn){
        $queues = queueGetter($conn, null);
        return $queues;
    }

    function addQueue($conn, $queue){
        $Name = $queue->getName();
        $Location = $queue->getLocation();

        try {
            $tsql = "INSERT INTO dbo.Queue (Name, Location)
                OUTPUT INSERTED.id VALUES ('$Name','$Location')";
            //Insert query
            $insertReview = sqlsrv_query($conn, $tsql);

            if ($insertReview == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }

            echo "Queue Key inserted is :";

            while($row = sqlsrv_fetch_array($insertReview, SQLSRV_FETCH_ASSOC))
            {
                $new_id = $row['id'];
                echo $new_id."<br>";
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



    function userGetter($conn, $condition){
        try

        {
            if($condition == NULL) {
                $tsql = "SELECT [id],[queue_id],[position] FROM dbo.Users";
            }
            else{
                $tsql = "SELECT [id],[queue_id],[position] FROM dbo.Users WHERE ".$condition;

            }
            echo "<br>TSQL= ".$tsql."<br>";
            $getUsers = sqlsrv_query($conn, $tsql);
            if ($getUsers == FALSE) {
                echo("Error!!<br>");
                die(print_r( sqlsrv_errors(), true));
            }


            while($row = sqlsrv_fetch_array($getUsers, SQLSRV_FETCH_ASSOC))
            {
                $user = new User($row['queue_id']);
                $user->setPosition($row['position']);
                $user->setId($row['id']);
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
        $cond = "id =$id";
        $users = userGetter($conn, $cond);

        if (empty($users)){
            return "not found";
        }
        return $users[0];
    }

    function getUsers($conn, $queue_id){
        $condition = "queue_id = " . $queue_id;
        $users = userGetter($conn, $condition);
        return $users;
    }

    function addUser($conn, $user){
        $QueueId = $user->getQueueId();
        $Position = getLastInLine($conn, $QueueId);
        $Position++;

        try {
            $tsql = "INSERT INTO dbo.Users (queue_id, position)
                    OUTPUT INSERTED.id VALUES ('$QueueId','$Position')";
            //Insert query
            $insertReview = sqlsrv_query($conn, $tsql);

            if ($insertReview == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }


            while($row = sqlsrv_fetch_array($insertReview, SQLSRV_FETCH_ASSOC))
            {
                $new_id = $row['id'];
            }
            sqlsrv_free_stmt($insertReview);
            sqlsrv_close($conn);
        }
        catch(Exception $e)
        {
            echo("Add User Error!");
        }

        if (empty($new_id)){
            return null;
        }else{
            return $new_id;
        }
    }



    function getfirstInLine($conn, $queue_id){
        try{
            $tsql = "SELECT TOP 1 position FROM dbo.Users WHERE queue_id=".$queue_id." ORDER BY position ASC";
            echo $tsql;
            $results = sqlsrv_query($conn, $tsql);

            if ($results == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }

            $results = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
            $result = $results['position'];
            return $result;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function getLastInLine($conn, $queue_id){
        try{
            $tsql = "SELECT TOP 1 position FROM dbo.Users WHERE queue_id=".$queue_id." ORDER BY position DESC";
            $results = sqlsrv_query($conn, $tsql);

            if ($results == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }

            $results = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
            $result = $results['position'];
            return $result;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function deQueueUser($conn, $queue_id){
        try{
            $tsql = "WITH q AS
            (SELECT TOP 1 *
            FROM dbo.Users ORDER BY position ASC) DELETE FROM q";
            $results = sqlsrv_query($conn, $tsql);

            if ($results == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }
            return $results;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }