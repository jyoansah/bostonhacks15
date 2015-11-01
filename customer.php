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
		
    	<form method="POST" action="">
        	<button name="new_customer" value="submit">Get Number</button>
        </form>
        
    </body>
</html>