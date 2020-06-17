<?php

    $state = 'register';
    $title = 'Register';
    if (isset($_SESSION['user'])) {
        $state = 'profile';
        $title = 'Profile';
    }

    $_REQUEST['username']=!empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
    $_REQUEST['first']=!empty($_REQUEST['first']) ? $_REQUEST['first'] : '';
    $_REQUEST['last']=!empty($_REQUEST['last']) ? $_REQUEST['last'] : '';
    $_REQUEST['given']=!empty($_REQUEST['given']) ? $_REQUEST['given'] : '';
    $_REQUEST['gender']=!empty($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
    $_REQUEST['dob']=!empty($_REQUEST['dob']) ? $_REQUEST['dob'] : '';
    $_REQUEST['yearofstudy']=!empty($_REQUEST['yearofstudy']) ? $_REQUEST['yearofstudy'] : '';
    $_REQUEST['study']=!empty($_REQUEST['study']) ? $_REQUEST['study'] : array();

    if(isset($_SESSION['user'])) {
        $_REQUEST['username'] = $_SESSION['user']->username;
        $_REQUEST['first'] = $_SESSION['user']->first;
        $_REQUEST['last'] = $_SESSION['user']->last;
        $_REQUEST['given'] = $_SESSION['user']->given;
        $_REQUEST['gender'] = $_SESSION['user']->gender;
        $_REQUEST['dob'] = $_SESSION['user']->dob;
        $_REQUEST['yearofstudy'] = $_SESSION['user']->yearofstudy;
        $_REQUEST['study'] = $_SESSION['user']->study;
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title?></title>
        <link href="./style.css" rel="stylesheet">
        <style>
            td {
                vertical-align: text-top;
                padding-right: 20px;
            }
            input[type="date"] {
                width: 150px;
            }
            .dropbox {
                width: 150px;
            }

        </style>
	</head>
	<body>
        <?php if (isset($_SESSION['user'])) {
            NavBar($state,1);
        } else {
            NavBar($state,0);
        }?>
        <main>
		<h1><?php echo $title?></h1>
        <hr>
        <form method="GET" id="cancel"></form>
		<form method="POST" id="submit">
			<div>
				First Name*
                <input type="text" class="input" name="first" size="25" 
                    pattern="[A-Za-z0-9]{1,20}"
                    title="Must contain no more than 20 alphanumeric characters" 
                    value="<?php echo $_REQUEST['first'];?>" required>

            </div>
            <div>
				Last Name*
                <input type="text"  class="input" name="last" size="25"
                    pattern="[A-Za-z0-9]{1,20}"
                    title="Must contain no more than 20 alphanumeric characters"
                    value="<?php echo $_REQUEST['last'];?>" required>
            </div>
            <div>
				Given Name
                <input type="text" class="input" name="given" size="25"
                    pattern="[A-Za-z0-9]{0,20}"
                    title="Must contain no more than 20 alphanumeric characters"
                    value="<?php echo $_REQUEST['given']; ?>" >
			</div>
            <hr>
            <div>
            Gender*
            <select class="input dropbox" name="gender" >
                <?php if($_REQUEST['gender']==="") print("
                    <option value=''  selected disabled hidden>Choose here</option>
                ");    
                ?>
                <option value="1" <?php if($_REQUEST['gender']==="1") echo "selected";?>>M</option>
                <option value="2" <?php if($_REQUEST['gender']==="2") echo "selected";?>>F</option>
            </select>
            </div>
            <div>
                DOB*
                <input type="date" class="input" name="dob" 
                    value="<?php echo $_REQUEST['dob'] ?>" required>
            </div>
            
            <hr>
			<table><tr><td>
                Year of Study*

				<br>
                <label><input type="radio" name="yearofstudy" value="1" 
                    <?php if($_REQUEST['yearofstudy']=="1") echo "checked";?> >1</label>
				<br>
                <label><input type="radio" name="yearofstudy" value="2" 
                    <?php if($_REQUEST['yearofstudy']=="2") echo "checked";?> >2</label>
				<br>
                <label><input type="radio" name="yearofstudy" value="3" 
                    <?php if($_REQUEST['yearofstudy']=="3") echo "checked";?> >3</label>
                <br>
                <label><input type="radio" name="yearofstudy" value="4"
                    <?php if($_REQUEST['yearofstudy']=="4") echo "checked";?> >4</label>
                <br>
                <label><input type="radio" name="yearofstudy" value="5"
                    <?php if($_REQUEST['yearofstudy']=="5") echo "checked";?> >4+</label>
            </td>
            <td>
                Fields of Study
                <br>
                <label><input type="checkbox" name="study[]" value="bio"
                    <?php if(in_array("bio", $_REQUEST['study']))  echo "checked";?> >Biology</label>
                <br>
                <label><input type="checkbox" name="study[]" value="chm"
                    <?php if(in_array("chm", $_REQUEST['study']))  echo "checked";?>>Chemistry</label>
                <br>
                <label><input type="checkbox" name="study[]" value="csc"
                    <?php if(in_array("csc", $_REQUEST['study']))  echo "checked";?>>Computer Science</label>
                <br>
                <label><input type="checkbox" name="study[]" value="eco"
                    <?php if(in_array("eco", $_REQUEST['study']))  echo "checked";?>>Economics</label>
                <br>
                <label><input type="checkbox" name="study[]" value="fin"
                    <?php if(in_array("fin", $_REQUEST['study']))  echo "checked";?>>Finance</label>
                <br>
                <label><input type="checkbox" name="study[]" value="mat"
                    <?php if(in_array("mat", $_REQUEST['study']))  echo "checked";?>>Mathematics</label>
                <br>
                <label><input type="checkbox" name="study[]" value="phy"
                    <?php if(in_array("phy", $_REQUEST['study']))  echo "checked";?>>Physics</label>
                <br>
                <label><input type="checkbox" name="study[]" value="psy"
                    <?php if(in_array("psy", $_REQUEST['study']))  echo "checked";?>>Psychology</label>
                <br>
                <label><input type="checkbox" name="study[]" value="sco"
                    <?php if(in_array("sco", $_REQUEST['study']))  echo "checked";?>>Social Science</label>
                <br>
                <label><input type="checkbox" name="study[]" value="sta"
                    <?php if(in_array("sta", $_REQUEST['study'])) echo "checked";?>>Statistics</label>
                <br>
            </td></tr></table>
            <hr>
            
            <div>
            <?php if ($state=="register") echo "Username" ?> 
            <input type="text" class="input" name="username"
                pattern="[A-Za-z0-9]{8,20}"
                title="Must contain 8-20 alphanumeric characters"
                value="<?php echo $_REQUEST['username']?>"
                 <?php if ($state=="profile") echo "style='display: none;' " ?> 
                required>
            </div>
            <?php if ($state=="register") {?>
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
            
            <?php }?>
            <?php echo(page_token()); ?>
        </form>
        <?php if ($state=="register") {?>
            <button type="submit" form="submit" name="submit" value="register">Submit</button>
            <button type="submit" form="cancel" name="submit" value="cancel">Cancel</button>  
        
        <?php } else {?>
            <button type="submit" form="submit" name="submit" value="profile">Update</button>
            <button type="submit" form="cancel" name="submit" value="forgot">Reset password</button>
            <button type="submit" form="cancel" name="submit" value="cancel">Cancel</button>
        <?php } ?>
        <?php echo(view_msg($msg)); ?>
        <?php echo(view_msg($system_errors)); ?>
        </main>
	</body>
</html>

