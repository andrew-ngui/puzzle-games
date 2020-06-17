<?php
	// So I don't have to deal with uninitialized $_REQUEST['guess']
	$_REQUEST['guess']=!empty($_REQUEST['guess']) ? $_REQUEST['guess'] : '';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Guess Game</title>
		<link href="./style.css" rel="stylesheet">
	</head>
	<body>
		<?php NavBar("guessGame",1) ?>
		<main>
		<h1>GuessGame</h1>
		<?php 
		$disabled = "disabled";
		if($_SESSION["game"]->getState()!="correct"){ 
			$disabled = ""; 
		}
		?>
			<form id="reset" method="POST"></form>
			<form id="cancel" method="GET"></form>
			<form id="submit" method="POST">
			<input type="text" class="input" name="submit"
                pattern="[1-9]|10"
                title="Must contain a number from 1-10"
                value="" <?php echo $disabled?> 
                required>

				<input class='button' type="submit" name="guess" value="guess" 
				 <?php echo $disabled?>>
				<?php echo(page_token()) ?>
			</form>	
		<?php	
			$reset = "reset";
			if($_SESSION["game"]->getState()=="correct"){ 
				$reset = "start again";
			}
		?>
		<button form="reset" type="submit" name="submit" value="reset">
			<?php echo $reset;?>
		</button>
		<button form="cancel" type="submit" name="submit" value="cancel">
			cancel
		</button>
		
		<?php 
			foreach($_SESSION['game']->history as $key=>$value){
				echo("<br/> $value");
			}
		?>
		<?php echo(view_msg($msg)."<br>"); ?> 	
		</main>
	</body>
</html>

