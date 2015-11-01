<?php

function testFunction($conn){
    echo "Private to mars function works";
    $dbname = DATABASE;
    $dbtable = "Queue";
            
    try {
        $tsql = "INSERT $dbame.$dbtable (name, location) "
                . "OUTPUT INSERTED.id VALUES ('SQL Server 1', 'SQL Server 2')";
        
        //Insert query
        $insertReview = sqlsrv_query($conn, $tsql);
        if ($insertReview == FALSE) {
            echo "Product creation failed";

            die(FormatErrors(sqlsrv_errors()));
        }else{
            echo "Product creation success";
        }
        echo "Product Key inserted is :";   
        while($row = sqlsrv_fetch_array($insertReview, SQLSRV_FETCH_ASSOC))
        {   
            echo($row['ProductID']);
        }
        sqlsrv_free_stmt($insertReview);
        sqlsrv_close($conn);
    }
    catch(Exception $e)
    {
        echo("Error!");
    }
}

function testFunctionCreate($conn){
    echo "Private to mars function works";
    
    $tsql = "CREATE TABLE MyGuests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    reg_date TIMESTAMP
    )";
    
    $getProducts = sqlsrv_query($conn, $tsql);
    if ($getProducts == FALSE) {
        echo "Product creation failed";
        die(FormatErrors(sqlsrv_errors()));
    }
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