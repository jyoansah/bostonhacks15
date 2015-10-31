<?php

require_once 'definition.php';

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

//Gets user agent
function NQGetAgent() {
    return filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');
}

//Checks if variable $str if a valid utf-8 encoding
function NQValidUTF8($str) {
    return (bool) preg_match('//u', $str);
}

//Creats a sha512 hash
function NQHash($param1, $param2, $default = false) {
    return hash('sha512', $param1 . $param2, $default);
}

//Create random string of length
function NQRandomString($length = "10", $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count - 1)];
    }
    return $str;
}

//Generates New User ID from table
function NQGetNextGenID($conn, $id, $table, $order) {
    $param = " ORDER BY $order DESC LIMIT 1";

    $stmt = NQSelect($conn, $id, $table . $param);
    $result = NQProcessQuery($stmt, true);
    $userID = $result ? substr($result[0][$id], 6, strlen($result[0][$id])) : "-1";

    return NQSanitizeID($userID + 1, strlen($userID) - 1);
}

//Sanitizes ID to only integer values
function NQSanitizeID($value, $length) {
    $strValue = "";

    //Base case
    if ($value === 0) {
        return "00000";
    }

    for ($i = strlen($value); $i <= $length; $i++) {
        $strValue.="0";
    }
    return $strValue . "" . $value;
}

//Ensures sessions is available
function NQAssertSession() {
    if (!isset($_SESSION)) {
        $session = new NQsession();
        $session->start_session('_s', false);
    }
}

//Encode result in json format
function sanitizeResult($result, $code = 200) {
    if (count($result) > 0) {
        NQSendResponse($code, json_encode($result));
        return true;
    } else {
        NQSendResponse($code, json_encode("ERROR"));
        return true;
    }
}

function testDumdum($conn){
    $tsql = "CREATE TABLE MyGuests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    reg_date TIMESTAMP
    )";
    $getProducts = sqlsrv_query($conn, $tsql);
    if ($getProducts == FALSE)
        die(FormatErrors(sqlsrv_errors()));
    $productCount = 0;
    while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))
    {
        echo($row['CompanyName']);
        echo("<br/>");
        $productCount++;
    }
    sqlsrv_free_stmt($getProducts);
    sqlsrv_close($conn);
}
//Default selects everything in table
function NQSelect($conn, $param, $table) {
    $sql = "SELECT $param FROM $table";
    $stmt = $conn->prepare($sql);

    return $stmt;
}

//Selects row in table by specific params
function NQSelectWhere($conn, $param, $table, $searchBy, $limit = "-1", $op = "AND") {
    $where = NQBasicWherePreProcessor($searchBy, $op);

    $sql = $limit === "-1" ? "SELECT $param FROM $table WHERE $where" : "SELECT $param FROM $table WHERE $where LIMIT " . $limit;
    $stmt = $conn->prepare($sql);
    NQBasicBindParamPreProcessor($stmt, $searchBy);

    return $stmt;
}

//Inserts row in table
function NQInsert($conn, $searchBy, $table) {
    $param = NQMultiplePreProcessor($searchBy);
    $sql = "INSERT INTO $table $param";
    $stmt = $conn->prepare($sql);
    NQBasicBindParamPreProcessor($stmt, $searchBy, true);

    return $stmt;
}

//Updates row in table
function NQUpdate($conn, $setValue, $table, $searchBy, $setOp = ",", $whereOp = "AND") {

    $param = NQBasicWherePreProcessor($setValue, $setOp);
    $where = NQBasicWherePreProcessor($searchBy, $whereOp);
    $sql = "UPDATE $table SET $param WHERE $where";
    $stmt = $conn->prepare($sql);
    NQBasicBindParamPreProcessor($stmt, $setValue);
    NQBasicBindParamPreProcessor($stmt, $searchBy);

    return $stmt;
}

//Replaces row in table
function NQReplace($conn, $searchBy, $table) {
    $param = NQMultiplePreProcessor($searchBy);
    $sql = "REPLACE INTO $table $param";
    $stmt = $conn->prepare($sql);
    NQBasicBindParamPreProcessor($stmt, $searchBy, true);

    return $stmt;
}

//Deletes row in table
function NQDeleteWhere($conn, $table, $searchBy, $op = "AND") {
    $where = NQBasicWherePreProcessor($searchBy, $op);
    $sql = "DELETE FROM $table WHERE $where";
    $stmt = $conn->prepare($sql);
    NQBasicBindParamPreProcessor($stmt, $searchBy);

    return $stmt;
}

//Begin PDO Database transactions
function NQBeginTransaction() {
    global $conn;
    return $conn->beginTransaction();
}

//End PDO Database transactions
function NQEndTransaction() {
    global $conn;
    return $conn->commit();
}

//Rollback PDO Database transactions
function NQCancelTransaction() {
    global $conn;
    return $conn->rollBack();
}

//Processes a PDO query
function NQProcessQuery($stmt, $fetch = false) {
    try {
        $stmt->execute();
        return $fetch ? NQFetch($stmt) : true;
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}

//Get result count
function NQRowCount($stmt) {
    return $stmt->rowCount();
}

//Fetches result after PDO execution
function NQFetch($stmt) {
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    return NQResult($result);
}

//Fetches single result after PDO execution
function NQFetchSingle($stmt) {
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetch();

    return NQResult($result);
}

//Checks if result is null
function NQResult($result) {
    return empty($result) ? false : $result;
}

//Processes Basic Multiple Name-Pair values
//@Return (fname, lname) VALUES (:fname, :lname);
function NQMultiplePreProcessor($param) {

    if (empty($param)) {
        return false;
    }

    return "(" . NQMultiplePreProcessorHelper($param) . ") VALUES (" . NQBasicPlaceholder($param) . ")";
}

//Helper method for basic multiple name-pair values
function NQMultiplePreProcessorHelper($param, $literal = false) {
    $result_string = "";
    $count = 0;

    foreach (array_keys($param) as $k) {
        $literal ? $result_string .= "'$k'" : $result_string .= "$k";
        $result_string .= ($count === count($param) - 1) ? "" : ",";
        $count++;
    }

    return $result_string;
}

//Helper method returns a basic placeholder
//@Return :where
function NQBasicPlaceholder($param) {
    $result_string = "";
    $count = 0;

    foreach (array_keys($param) as $k) {
        $result_string .= ":" . $k;
        $result_string .= ($count === count($param) - 1) ? "" : ",";
        $count++;
    }

    return $result_string;
}

//Sets Where clause for SQL queries
//@Return - where = :where AND where2 < :where2
//if == 
function NQBasicWherePreProcessor($param, $op = "AND") {
    $result_string = "";
    $count = 0;

    //Base Case
    $op_ = count($param) === 1 ? "" : $op;

    foreach ($param as $k => &$v) {
        $sub = substr($k, 0, strlen($k) - 1);
        $result_string .= substr($k, strlen($k) - 2, strlen($k)) != "==" ? $k . ":" . NQSanitizeBindParam($sub) : $sub . "'" . $v . "'";
        $result_string .= ($count === count($param) - 1) ? "" : " " . $op_ . " ";
        $count++;
    }

    return $result_string;
}

//Cleans up params
function NQSanitizeBindParam($string) {
    return str_replace(array('.', ','), '', $string);
}

//Bind Multiple parameters
//@Return - $stmt->bindParam(':where', $val);
//$stmt->bindParam(':where2', $val2);
function NQBasicBindParamPreProcessor($stmt, $param, $op = false) {
    $count = 0;
    foreach ($param as $k => &$v) {
        if (substr($k, strlen($k) - 2, strlen($k)) != "==") {
            !$op ? $stmt->bindParam(":" . NQSanitizeBindParam(substr($k, 0, strlen($k) - 1)), $v) : $stmt->bindParam(":" . $k, $v);
        }
        $count++;
    }
}

//Sends feedback message
function sanitizeFEEDBACK($message) {
    if (isset($_SESSION['feedback_message']) || isset($message)) {
        $message = isset($_SESSION['feedback_message']) ? $_SESSION['feedback_message'] : $message;
        
        if(isset($_SESSION['feedback_message'])){
            unset($_SESSION['feedback_message']);
            $_SESSION['feedback_message'] = NULL;
        }
    }
    
    return false;
}
 
//Sets feedback message
function setFeedbackMessage($message) {
    $_SESSION['feedback_message'] = $message;
}