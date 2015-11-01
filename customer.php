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
        <title>Customer</title>
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
				echo '<a href="/customer.php/?id='.$queue->id.'">'.$queue->name.'</a><br>';
			}
			?>
		</div>
		<?php
	}
	catch(Exception $e){
		echo $e->getMessage();
	}
	?>

		</div>
		<?php

			
			//Get current customer
			if(isset($_POST['new_customer']) && isset($_GET['id'])){
				echo '<div id="queue_number">';
				try{
					
					$new_user = new User($_GET['id']);
					$results = addUser($conn, $new_user);
					$_SESSION['position'];
					echo "Your queue number is:". $results;
				}
				catch(Exception $e){
					echo $e->getMessage();
				}
				echo '</div>';
			}
			if(isset($_GET['id'])){
				$firstInLine = getfirstInLine($conn, $_GET['id']);
				echo '<div id="firstInLine">';
				echo "Now Serving: ".$firstInLine;
				echo '</div>';

				$lastInLine = getLastInLine($conn, $_GET['id']);
				echo '<div id="lastInLine">';
				echo "Last In Line: ".$lastInLine;
				echo '</div>';
			}
			if(isset($_SESSION['position'])){
				echo '<div id="position">';
				echo "Your current position is: ".$_SESSION['position'];
				echo '</div>';
			}
			if (!isset($_POST['new_customer']) && isset($_GET['id'])){
	    	echo '<form method="POST" action="">';
	        echo '<button name="new_customer" value="submit">Get Number</button>';
	        echo '</form>';
	    }   
   ?>
    </body>
</html>