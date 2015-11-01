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

		</div>
		<?php
			//Get current customer
			if(isset($_POST['new_customer']) & isset($_GET['id'])){
				echo '<div id="queue_number">';
				try{
					$new_user = new User($_GET['id']);
					$results = addUser($new_user);
					echo "Your queue number is:". $results;
				}
				catch(Exception $e){
					echo $e->getMessage();
				}
				echo '</div>'
			}
			else{
		?>
    	<form method="POST" action="">
        	<button name="new_customer" value="submit">Get Number</button>
        </form>
        <?php
    }
    ?>
    </body>
</html>