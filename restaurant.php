<!DOCTYPE html>
<?php 
 header("access-control-allow-origin: *");
 include_once 'api/api.php';
 global $conn, $api;
 session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Restaurant Control Panel</title>
    </head>
    <body>
    	
<?php
	try{
		?>
		<div id="sidebar">
			<?php
			$queues = getqueues($conn);
			foreach($queues as $queue){
				echo "Location: ".$queue->location." ";
				echo '<a href="/restaurant.php/?id='.$queue->id.'">'.$queue->name.'</a><br>';
				
				//echo '<a href="restaurant.php/?id='.$queue["id"].'">'."sup".$queue['name'].'</a>"';
			}
			?>
		</div>
		<?php
	}
	catch(Exception $e){
		echo $e->getMessage();
	}

	
	//Get current customer
	if(isset($_POST['next_customer'])){
		try{
			$result = deQueueUser($conn, $_SESSION['id']);
			echo '<form method="POST" action="">';
        	echo '<button name="next_customer" value="submit">Next customer</button>';
        	echo '</form>';
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
	if(isset($_GET['id'])){
		$_SESSION['id'] = $_GET['id'];	
		//Get list of all people in the queue
		$queue_users = getUsers($conn, $_SESSION['id']);
		foreach($queue_users as $queue_user){
				echo "id: ".$queue_user->id.", ";
				echo "Queue id: ".$queue_user->queue_id.", ";
				echo "Position: ".$queue_user->position."<br>";
			}

		try{
			$current_position = getfirstInLine($conn, $_SESSION['id']);
			echo 'Now serving: ' .$current_position;
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}

		
		
?>

    	
    </body>
</html>