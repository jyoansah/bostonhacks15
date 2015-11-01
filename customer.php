<!DOCTYPE html>
<?php 
 header("access-control-allow-origin: *");
 include_once 'api/api.php';
 global $conn, $api;
 session_start();
?>

<?php
	//Get current customer
	$query = mysql_fetch_row(mysql_query("SELECT queue_position FROM user" WHERE ));
	if(isset($_POST['new_customer'])){
		try{
			$result = mysql_fetch_row(mysql_query("INSERT INTO user (queue_id) VALUES (".$_SESSION['queue_id'].")"));		
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}
	try{
		$result = mysql_fetch_row(mysql_query("SELECT * FROM user ORDER BY queue_position DESC LIMIT 1 WHERE queue_id=".$_SESSION['queue_id']));
		$current_user = $result['queue_position'];	
	}
		catch(Exception $e){
			echo $e->getMessage();
		}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer</title>
    </head>
    <body>
    	Now serving: <?php echo $current_user; ?>
    	<form method="POST" action="">
        	<button name="new_customer" value="submit">Get Number</button>
        </form>
    </body>
</html>