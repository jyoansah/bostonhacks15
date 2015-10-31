<?php

function testFunction($conn){
    echo "Private to mars function works!!!";
    
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