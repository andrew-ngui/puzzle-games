<?php
if(isset($_SESSION['user'])) {
    $_REQUEST['username'] = $_SESSION['user']->username;
    $_REQUEST['dob'] = $_SESSION['user']->dob;
}
$_REQUEST['username']=!empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
$_REQUEST['dob']=!empty($_REQUEST['dob']) ? $_REQUEST['dob'] : '';

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Reset Password</title>
        <link href="./style.css" rel="stylesheet">
        <style>
            input[type="date"] {
                width: 150px;
            }
        </style>
	</head>
	<body>
        <?php if(isset($_SESSION['user'])) {
                NavBar(NULL,1);
            } else {
                NavBar(NULL,0);
            } ?>
        <main>
		<h1>Reset Password</h1>
        <form method="get" id="cancel"></form>
        <form method="post" id="submit">
            
            <div  <?php if(isset($_SESSION['user']))echo "style='display: none;'"; ?>>
                Username
                <input type="text" class="input" name="username"
                    title="Must contain 8-20 characters"
                    pattern="[A-Za-z0-9]{8,20}"
                    title="Must contain 8-20 alphanumeric characters"
                    value="<?php echo $_REQUEST['username'] ?>" required>
            </div>
            <div <?php if(isset($_SESSION['user']))echo "style='display: none;'"; ?>>
                DOB*
                <input type="date" class="input" name="dob" 
                    value="<?php echo $_REQUEST['dob'] ?>" required>
            </div>
            <div>
                Password (8 characters minimum)
                <input type="password" class="input" name="password"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}"
                    title="Must contain at least one number and one uppercase and lowercase letter, and 8-20 characters"
                    value="" required>
            </div>
            <div>
                Confirm Password
                <input type="password" class="input" name="cpassword"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}"
                    title="Must contain at least one number and one uppercase and lowercase letter, and 8-20 characters"
                    value="" required>
            </div>
            <?php echo(page_token()) ?>
        </form>
			
            <button type="submit" form="submit" name="submit" value="forgot">Submit</button>
            <button type="submit" form="cancel" name="submit" value="cancel">Cancel</button>  
            <?php echo(view_msg($msg)); ?>
            <?php echo(view_msg($system_errors)); ?>
        </main>
	</body>
</html>

