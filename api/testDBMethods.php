<?php

function ReadData($conn) {
    try
    {
        $tsql = "SELECT [Name] FROM deeque.Queue";
        $getProducts = sqlsrv_query($conn, $tsql);
        
        if ($getProducts == FALSE) {
            echo "read f";
            die(FormatErrors(sqlsrv_errors()));
        }else{
            echo "read success";
        }
        
        $productCount = 0;
        while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))
        {
            echo($row['Name']);
            echo("<br/>");
            $productCount++;
        }
        sqlsrv_free_stmt($getProducts);
        sqlsrv_close($conn);
    }
    catch(Exception $e)
    {
        echo("Error!");
    }
}