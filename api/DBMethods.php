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
            if(empty($condition)) {
                $tsql = "SELECT [id],[Name],[Location] FROM dbo.Queue";
            }
            else{
                $tsql = "SELECT [id],[Name],[Location] FROM dbo.Queue WHERE $condition";

            }
            echo $tsql;
            $conn = OpenConnection();
            $getQueues = sqlsrv_query($conn, $tsql);
            if ($getQueues == FALSE) {
                echo("Error!!<br>");
                die(print_r( sqlsrv_errors(), true));
            }


            while($row = sqlsrv_fetch_array($getQueues, SQLSRV_FETCH_ASSOC))
            {
                $queue = new Queue($row['Name'],$row['Location']);
                $queue->setId($row['id']);
                $queues[] = $queue;

            }

            sqlsrv_free_stmt($getQueues);
            sqlsrv_close($conn);

            if (!empty($queues)) {
                return  $queues;
            }else{
                return null;
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
            return "Queue not found!";
        }
        return $queues[0];
    }

    function getQueues($conn){
        $queues = queueGetter($conn, null);
        if (empty($queues)){
            return "No queues available";
        }
        return $queues;
    }

    function addQueue($conn, $queue){
        $Name = $queue->getName();
        $Location = $queue->getLocation();

        try {
            $tsql = "INSERT INTO dbo.Queue (Name, Location)
                OUTPUT INSERTED.id VALUES ('$Name','$Location')";
            //Insert query
            $conn = OpenConnection();
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

            if (empty($new_id)){
                return null;
            }else{
                return $new_id;
            }

        }
        catch(Exception $e)
        {
            echo("Add Queue Error!");
        }

    }



    function userGetter($conn, $condition){
        try

        {
            if(empty($condition)) {
                $tsql = "SELECT [id],[queue_id],[position] FROM dbo.Users";
            }
            else{
                $tsql = "SELECT [id],[queue_id],[position] FROM dbo.Users WHERE ".$condition;

            }
            $conn = OpenConnection();
            $getUsers = sqlsrv_query($conn, $tsql);

            if ($getUsers == FALSE) {
                echo("Error!!<br>");
                //die(print_r( sqlsrv_errors(), true));
            }


            while($row = sqlsrv_fetch_array($getUsers, SQLSRV_FETCH_ASSOC))
            {
                $user = new User($row['queue_id']);
                $user->setPosition($row['position']);
                $user->setId($row['id']);
                $users[] = $user;

            }

            sqlsrv_free_stmt($getUsers);
            sqlsrv_close($conn);

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


    function addUserDB($conn, $user){

        $QueueId = $user->getQueueId();
        $Position = getLastInLine($conn, $QueueId);
        $Tel = $user->getTel();
        $Position++;

        try {

            if(empty($Tel)) {
                $tsql = "INSERT INTO dbo.Users (queue_id, position)
                    OUTPUT INSERTED.position VALUES ('$QueueId','$Position')";
            }
            else {
                $tsql = "INSERT INTO dbo.Users (queue_id, position, telephone)
                    OUTPUT INSERTED.position VALUES ('$QueueId','$Position', '$Tel')";

            }
            //Insert query
            $conn = OpenConnection();
            $insertReview = sqlsrv_query($conn, $tsql);

            if ($insertReview == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }


            while($row = sqlsrv_fetch_array($insertReview, SQLSRV_FETCH_ASSOC))
            {
                $new_position = $row['position'];
            }
            sqlsrv_free_stmt($insertReview);
            sqlsrv_close($conn);

        }
        catch(Exception $e)
        {
            echo("Add User Error!");
        }

        if (empty($new_position)){
            return null;
        }else{
            return $new_position;
        }
    }

    function addUser($conn, $user){
        $array = [
            "queue" => getQueue($conn, $user->getQueueId())->getName(),
            "position" => addUserDB($conn,$user),
            "serving" => getfirstInLine($conn, $user->getQueueId()),
        ];
        return $array;
    }


    function getfirstInLine($conn, $queue_id){
        try{
            $tsql = "SELECT TOP 1 position FROM dbo.Users WHERE queue_id=".$queue_id." ORDER BY position ASC";

            $conn = OpenConnection();
            $results = sqlsrv_query($conn, $tsql);

            if ($results == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }

            $results = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
            $result = $results['position'];

            sqlsrv_free_stmt($results);
            sqlsrv_close($conn);


            return $result;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function getLastInLine($conn, $queue_id){
        try{
            $tsql = "SELECT TOP 1 position FROM dbo.Users WHERE queue_id=".$queue_id." ORDER BY position DESC";

            $conn = OpenConnection();
            $results = sqlsrv_query($conn, $tsql);

            if ($results == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }

            $results = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
            $result = $results['position'];

            sqlsrv_free_stmt($results);
            sqlsrv_close($conn);

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

            $conn = OpenConnection();
            $results = sqlsrv_query($conn, $tsql);

            if ($results == FALSE) {
                die(print_r( sqlsrv_errors(), true));
            }

            sqlsrv_close($conn);

            return $results;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

