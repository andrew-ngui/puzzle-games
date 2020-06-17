<?php

$_REQUEST['username']=!empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
$_REQUEST['password']=!empty($_REQUEST['password']) ? $_REQUEST['password'] : '';

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Games</title>
		<link href="./style.css" rel="stylesheet" >
	</head>
	<body>
		<?php NavBar($_SESSION['state'],0) ?>
		<main>
		<h1>Please login</h1>
		<form id="page" method="get"></form>
		<form id="login" method="post">
				<!-- Trick below to re-fill the user form field -->
				<div>Username:</div>
				<div><input type="text" class="input" name="username" value="<?php echo($_REQUEST['username']); ?>"/></div>
				<div>Password:</div>
				<div><input type="password" class="input" name="password" /></div>
				<div>
						<button form="login" type="submit" name="submit" value="login">login</button>
						<button form="page" type="submit" name="submit" value="register">register</button>
						<button form="page" type="submit" name="submit" value="forgot">forgot password</button>
				</div>
			<?php echo(page_token()) ?>
		</form>
		<br>
		<?php echo(view_msg($msg)); ?>
		<?php echo(view_msg($system_errors)); ?>
		</main>
		
	</body>
	
</html>


