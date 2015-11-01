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
            $tsql = "SELECT [id],[queue_id],[position] FROM dbo.Users WHERE $condition";

        }
        $getUsers = sqlsrv_query($conn, $tsql);
        if ($getUsers == FALSE) {
            echo("Error!!<br>");
            die(print_r( sqlsrv_errors(), true));
        }


        while($row = sqlsrv_fetch_array($getUsers, SQLSRV_FETCH_ASSOC))
        {
            $user = new User($row['id'],$row['queue_id'],$row['position']);
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
    $Position = $user->getPosition();

    try {
        $tsql = "INSERT INTO dbo.Users (queue_id, position)
                OUTPUT INSERTED.id VALUES ('$QueueId','$Position')";
        //Insert query
        $insertReview = sqlsrv_query($conn, $tsql);

        if ($insertReview == FALSE) {
            die(print_r( sqlsrv_errors(), true));
        }

        echo "User Key inserted is :";

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
        $tsql = "SELECT position FROM user ORDER BY position DESC LIMIT 1 WHERE queue_id=".$queue_id;
        $results = sqlsrv_query($conn, $tsql);

        if ($results == FALSE) {
            die(print_r( sqlsrv_errors(), true));
        }

        return $results[0];

    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}