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

function GeSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
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

    try {

        $conn = OpenConnection();

        if (empty($condition)) {
            $sql = "SELECT id, Name,Location FROM Queue";
        } else {
            $sql = "SELECT id,Name,Location FROM Queue WHERE $condition";
        }


        foreach($conn->query($sql) as $row) {
                $queue = new Queue($row["Name"], $row["Location"]);
                $queue->setId($row["id"]);
                $queues[] = $queue;
        }

        $conn = null;

        if (!empty($queues)) {
            return $queues;
        } else {
            return null;
        }

    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
}

function getQueue($conn, $id){
    $cond = "id =".intval($id);
    $queues = queueGetter($conn, $cond);

    if (empty($queues)){
        return null;
    }else{
        return $queues[0];
    }

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
        $sql = "INSERT INTO Queue (Name, Location)
                VALUES ('$Name','$Location')";
        //Insert query
        $conn = OpenConnection();
        $conn->exec($sql);

        $new_id = $conn->lastInsertId();

        $conn = null;

        if (empty($new_id)){
            return null;
        }else{
            return $new_id;
        }

    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }

}



function userGetter($conn, $condition){
    try
    {

        $conn = OpenConnection();

        if(empty($condition)) {
            $sql = "SELECT id,queue_id,position FROM Users";
        }
        else{
            $sql = "SELECT id,queue_id,position FROM Users WHERE ".$condition;

        }

        foreach ($conn->query($sql) as $row) {
                $user = new User($row["queue_id"]);
                $user->setPosition($row["position"]);
                $user->setId($row["id"]);
                $users[] = $user;
        }

        $conn = null;

        if (!empty($users)) {
            return  $users;
        }else{
            return null;
        }
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
}

function getUser($conn, $id){
    $cond = "id =$id";
    $users = userGetter($conn, $cond);

    if (empty($users)){
        return "not found";
    }
    return $users;
}

function getUsers($conn, $queue_id){
    $condition = "queue_id = " . $queue_id;
    $users = userGetter($conn, $condition);
    return $users;
}


function addUserDB($conn, $user){

    $QueueId = $user->getQueueId();
    $Position = getLastInLine($conn, $QueueId);
//    echo "dblil:".$Position;
    $Tel = $user->getTel();
    $Position++;

    try {

        if(empty($Tel)) {
            $sql = "INSERT INTO Users (queue_id, position)
                    VALUES ('$QueueId','$Position')";
        }
        else {
            $sql = "INSERT INTO Users (queue_id, position, telephone)
                    VALUES ('$QueueId','$Position', '$Tel')";

        }
        $conn = OpenConnection();
        $conn->exec($sql);

        $new_position = $Position;

        $conn = null;

    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }

    if (empty($new_position)){
        return null;
    }else{
        return $new_position;
    }
}

function addUser($conn, $user){
    $array = [
        'queue_id' => $user->getQueueId(),
        "queue" => getQueue($conn, $user->getQueueId())->getName(),
        "position" => addUserDB($conn,$user),
        "serving" => getfirstInLine($conn, $user->getQueueId())
    ];
    return $array;
}


function getfirstInLine($conn, $queue_id){

    try{

        $conn = OpenConnection();

        $sql = "SELECT position FROM Users WHERE queue_id=".$queue_id." ORDER BY position ASC LIMIT 1";

        foreach ($conn->query($sql) as $row) {
            $result = $row["position"];
        }

        $conn = null;

        if (!empty($result)) {
            return  $result;
        }else{
            return null;
        }
    }
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }
}

function getLastInLine($conn, $queue_id){
    try{

        $conn = OpenConnection();

        $sql = "SELECT position FROM Users WHERE queue_id=".$queue_id." ORDER BY position DESC LIMIT 1";

        foreach ($conn->query($sql) as $row) {
            $result = $row["position"];
        }

        $conn = null;

        if (!empty($result)) {
            return  $result;
        }else{
            return null;
        }
    }
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }
}

function deQueueUser($conn, $queue_id){
    try{

        $conn = OpenConnection();

        $sql = "DELETE FROM Users where position = (Select * from
              (SELECT position FROM Users WHERE queue_id=".$queue_id." ORDER BY position ASC LIMIT 1) as q)";

        $conn->query($sql);

        $conn = null;

    }
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }
}

