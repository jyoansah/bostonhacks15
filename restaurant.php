<!DOCTYPE html>
<?php 
 header("access-control-allow-origin: *");
 include_once 'api/api.php';
 global $conn, $api;
 session_start();
?>

<?php
	echo "test";
	$queues = queueGetter($this->conn, NULL);
	var_dump($queues);
	/**
	while($row = sqlsrv_fetch_array($queues)){
		echo $row;
	}
	//Get current customer
	if(isset($_POST['next_customer'])){
		try{
			$result = sqlsrv_fetch_array(sqlsrv_query($this->conn, "DELETE FROM user 
						JOIN(SELECT MIN(queue_position) AS min_queue_pos FROM user) user2
						WHERE user.queue_position = user2.min_queue_pos
						"));		
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}
	try{
		$result = sqlsrv_fetch_array(sqlsrv_query($this->conn, "SELECT * FROM user ORDER BY queue_position DESC LIMIT 1 WHERE queue_id=".$_SESSION['queue_id']));
		$current_user = $result['queue_position'];	
	}
		catch(Exception $e){
			echo $e->getMessage();
		}
		**/
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Restaurant Control Panel</title>
    </head>
    <body>
    	Now serving: <?php echo $current_user; ?>
    	<form method="POST" action="">
        	<button name="next_customer" value="submit">Next customer</button>
        </form>
    </body>
</html>