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
        <link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.5/material.indigo-pink.min.css">
		<script src="https://storage.googleapis.com/code.getmdl.io/1.0.5/material.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <title>Restaurant Control Panel</title>
        <style type="text/css">
        .demo-card-wide.mdl-card {
		  width: 512px;
		}
		.demo-card-wide > .mdl-card__title {
		  color: #fff;
		  height: 176px;
		  background: url('http://www.getmdl.io/assets/demos/welcome_card.jpg') center / cover;
		}
		.demo-card-wide > .mdl-card__menu {
		  color: #fff;
		}
		</style>
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
			echo '<form method="POST" action="">';
        	echo '<button name="next_customer" value="submit">Next customer</button>';
        	echo '</form>';
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}

		
		
?>
<div class="mdl-layout__container has-scrolling-header"><div class="demo-layout mdl-layout mdl-layout--fixed-header mdl-js-layout mdl-color--grey-100 is-upgraded" data-upgraded=",MaterialLayout">
      <header class="demo-header mdl-layout__header mdl-layout__header--scroll mdl-color--grey-100 mdl-color-text--grey-800">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">Material Design Lite</span>
          <div class="mdl-layout-spacer"></div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable is-upgraded" data-upgraded=",MaterialTextfield">
            <label class="mdl-button mdl-js-button mdl-button--icon" for="search" data-upgraded=",MaterialButton">
              <i class="material-icons">search</i>
            </label>
            <div class="mdl-textfield__expandable-holder">
              <input class="mdl-textfield__input" type="text" id="search">
              <label class="mdl-textfield__label" for="search">Enter your query...</label>
            </div>
          </div>
        </div>
      </header>
      <div class="demo-ribbon"></div>
      <main class="demo-main mdl-layout__content">
        <div class="demo-container mdl-grid">
          <div class="mdl-cell mdl-cell--2-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
          <div class="demo-content mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 mdl-cell mdl-cell--8-col">
            



            



			<?php
			$queues = getqueues($conn);
			foreach($queues as $queue){
			?>
				<div class="demo-card-wide mdl-card mdl-shadow--2dp" style="margin-top:20px; left:27%;">
			  <div class="mdl-card__title">
			    <h2 class="mdl-card__title-text"><?php 	$queue->location; ?></h2>
			  </div>
			  <div class="mdl-card__supporting-text">
			    <?php
					echo '<a href="/restaurant.php/?id='.$queue->id.'">'.$queue->name.'</a><br>';
			    ?>
			  </div>
			  <div class="mdl-card__actions mdl-card--border">
			    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
			      Get Started
			    </a>
			  </div>
			  <div class="mdl-card__menu">
			    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
			      <i class="material-icons">share</i>
			    </button>
			  </div>
			</div><?php
			}
			?>

          </div>
        </div>
        <footer class="demo-footer mdl-mini-footer">
          <div class="mdl-mini-footer--left-section">
            <ul class="mdl-mini-footer--link-list">
              <li><a href="#">Help</a></li>
              <li><a href="#">Privacy and Terms</a></li>
              <li><a href="#">User Agreement</a></li>
            </ul>
          </div>
        </footer>
      </main>
    </div></div>
	
    	
    </body>
</html>