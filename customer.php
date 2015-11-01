<!DOCTYPE html>
<?php 
 header("access-control-allow-origin: *");
 include_once 'api/api.php';
 global $conn, $api;
 session_start();
?>

<?php
	//Get current customer
	if(isset($_POST['new_customer'])){
		try{
			$new_user = newUser();
			$results = addUser($new_user);
			echo "Your queue number is:". $results;
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer</title>
    </head>
    <body>
    	<form method="POST" action="">
        	<button name="new_customer" value="submit">Get Number</button>
        </form>
    </body>
</html>