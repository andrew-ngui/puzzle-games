<?php
function navBar($state,$mode) {
    $nav_main = array(
        "main" => "Home",
        "profile" => "Profile",
        "guessGame" => "Guess Game",
        "fifteenPuzzle" => "Fifteen Puzzle",
        "pegSolitaire" => "Peg Solitaire",
        "mastermind" => "Mastermind",
        "logout" => "Logout"
    );
    $nav_login = array(
        "login" => "Login",
        "register" => "Sign up"
    );
    $nav = $nav_main;
    if ($mode == 0) {
        $nav = $nav_login;
    }
    print("<nav class='navbar'><ul class='nav-ul'>");
    foreach ($nav as $key=>$value) {
        if ($key===$state) {
            print("<li class='nav-ul-li'><a class='nav-ul-li-a active'>".$value."</a></li>");
        } else {
            print("<li class='nav-ul-li'><a class='nav-ul-li-a' href='./index.php?submit=".$key."'>".$value."</a></li>");
        }
    }
    print("</ul></nav><div></div>");
}

function getState() {
    if(isset($_REQUEST['submit']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
		if ($_REQUEST['submit']=="fifteenPuzzle") {
            $_SESSION['state']="game";
            createGame("fifteenPuzzle");
		} elseif ($_REQUEST['submit']=="pegSolitaire") {
            $_SESSION['state']="game";
            createGame("pegSolitaire");
		} elseif ($_REQUEST['submit']=="guessGame") {
			$_SESSION['state']="game";
            createGame("guessGame");
		} elseif ($_REQUEST['submit']=="mastermind") {
			$_SESSION['state']="game";
            createGame("mastermind");
        } elseif ($_REQUEST['submit']=="cancel") {
            if (isset($_SESSION['user'])) {
                $_SESSION['state'] = 'main';
            } else {
                $_SESSION['state'] = 'login';
            }
        } elseif ($_REQUEST['submit']=="logout"){
            session_destroy();
            $_SESSION['state']="login";
        } else {
            $_SESSION['state'] = $_REQUEST['submit'];
        }
        header("Location: index.php");
        return;
    }
    
}

function createGame($gamename) {
    $_SESSION['game'] = NULL;
    if ($gamename === "fifteenPuzzle") {
        $_SESSION['gamename']="fifteenPuzzle";
        $_SESSION['game']=new FifteenPuzzle();
    } elseif ($gamename === "pegSolitaire") {
        $_SESSION['gamename']="pegSolitaire";
        $_SESSION['game']=new PegSolitaire();
    } elseif ($gamename === "guessGame") {
        $_SESSION['gamename']="guessGame";
        $_SESSION['game']=new GuessGame();
    } elseif ($gamename === "mastermind") {
        $_SESSION['gamename']="mastermind";
        $_SESSION['game']=new Mastermind();
    }

}





?>