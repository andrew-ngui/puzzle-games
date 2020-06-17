<?php
	require_once "model/FifteenPuzzle.php";
	require_once "model/PegSolitaire.php";
	require_once "model/GuessGame.php";
	require_once "model/Mastermind.php";
	require_once "model/User.php";
	require_once "model/Stats.php";
	require_once "lib/lib.php";
	require_once "view/navBar.php";
	
	//start a session with 1hr expiration period
	create_lifetime_session(3600);
	// ini_set('display_errors', 'On');
	$msg=array();
	$system_errors=array();

	//db connect
	$dbconn = db_connect();

	/* controller code */
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login';
	}

	// verify request page token
	// send the same page if request token
	// page token dont match
	if (isset($_SESSION['token'])
	&& isset($_REQUEST['token']) 
	&& $_SESSION['token']!==$_REQUEST['token']) {
		unset($_REQUEST['submit']);
	}
	// get the state 
	getState();

	switch($_SESSION['state']){
		case "login":
			// the view we display by default
			$view="login.php";
			
			// go to register
			if(isset($_REQUEST['submit']) && $_REQUEST['submit']=="register") {
				$view="profile.php";
				$_SESSION['state']="register";
				break;
			}
			// go to forgot password
			if(isset($_REQUEST['submit']) && $_REQUEST['submit']=="forgot password") {
				$view="forgotpassword.php";
				$_SESSION['state']="forgot";
				break;
			}

			// validate and set errors
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if(empty($_POST['username'])){
					$msg[]='user is required';
				}
				if(empty($_POST['password'])){
					$msg[]='password is required';
				}
				if(!empty($msg))break;
				if ($dbconn) {
					if(User::find_user($dbconn,$_REQUEST)){
						$_SESSION['user']=new User();
						$_SESSION['user']->extract_user($dbconn,$_REQUEST);
						$_SESSION['state']='main';
						$view="main.php";
						if (!isset($_SESSION['stats'])) {
							$_SESSION['stats'] = new Stats();
							$_SESSION['stats']->updateStats($dbconn, $_SESSION['user']->username);
						}
					} else {
						$msg[]="Invalid username or password";
					}
				} else {
					$system_errors[] = "Can't connect to the database.";
				}
			}


			// perform operation, switching state and view if necessary

		break;

		
		case "register":
			$view="profile.php";
			if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['submit'])){
				if ($_REQUEST['submit']=="register"){

					//check if password and confirmed password match
					if($_REQUEST['password'] != $_REQUEST['cpassword']) {
						$msg[] = "Password and Confirm Password do not match.";
						break;
					}
					if($dbconn) {
						//check if username is already taken
						if(User::add_user($dbconn,$_REQUEST)&&User::add_study($dbconn,$_REQUEST)){
							$_SESSION['state']="login";
							$view="login.php";
							session_destroy();
							header("Location: index.php");
							$msg[] = "Register successfully";

						} else {
							$msg[] = "Your username is already taken.";
							break;
						}
					} else {
						$system_errors[] = "Can't connect to the database.";
					}
				}
			}
			break;

		case "main":
			$view="main.php";
			if ($dbconn) {
				if(isset($_SESSION['stats'])) {
					$_SESSION['stats']->updateStats($dbconn, $_SESSION['user']->username);
				}
				// view displays the data, from _SESSION['stats']
			} else {
				$system_errors[] = "Can't connect to the database.";
			}
			break;

		case "forgot":
			$view="forgotpassword.php";
			if(isset($_REQUEST['submit'])){
				if ($_REQUEST['submit']=="forgot"){

					//check if password and confirmed password match
					if($_REQUEST['password'] != $_REQUEST['cpassword']) {
						$msg[] = "Password and Confirm Password do not match.";
						break;
					}
					
					if($dbconn) {
						//check if user info is valid
						if(User::reset_password($dbconn,$_REQUEST)) {
							$_SESSION['state']="login";
							$view="login.php";
							session_destroy();
							header("Location: index.php");
							
							$msg[] = "Reset password successfully";
						} else {
							$msg[]="User not found";
						}
					} else {
						$system_errors[] = "Can't connect to the database.";
					}
				}
			}


			break;

			case "profile":
				$view="profile.php";
				if(!empty($_REQUEST['submit'])){
					if ($_REQUEST['submit']=="profile"){
						if ($dbconn) {
							if($_SESSION['user']->update_user($dbconn,$_REQUEST) &&
							$_SESSION['user']->update_study($dbconn,$_REQUEST)) {
								$_SESSION['state']="main";
								$view="main.php";
							} else {
								$system_errors[] = "Can't connect to the database.";
							}
						}
					// go to forgot password
					} elseif ($_REQUEST['submit']=="forgot") {
						$_SESSION['state']='forgot';
						$view='forgotpassword.php';
					}
				}
			break;

			case "game":
				$view="view".$_SESSION['gamename'].".php";
				if($_SERVER['REQUEST_METHOD'] == 'POST' ) {
					if(isset($_REQUEST['submit'])) {
						//reset the game
						if($_REQUEST['submit']=='reset') {
							createGame($_SESSION['gamename']);
						} else {
							//play the game
							$_SESSION['game']->play($_REQUEST['submit']);
							//if win, store the stat to db
							if($_SESSION['game']->isWin()) {
								$_SESSION['user']->add_win($dbconn, $_SESSION['gamename'],
								$_SESSION['game']->getStat(), $_SESSION['game']->getTime());
								$_SESSION['game']->setWin();
						}	
					}
				}
			}
			break;
	}
	require_once "view/$view";

?>