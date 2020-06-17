<?php

class Stats {
    public $overall;
    public $PB_mastermind;
    public $PB_guessGame;
    public $PB_fifteenPuzzle;
    public $PB_pegSolitaire;

	public function __construct() {
        // store all best scores in one array
        $this->overall = array();
        // store top 3 scores per game
        $this->PB_mastermind= array();
        $this->PB_guessGame = array();
        $this->PB_fifteenPuzzle = array();
        $this->PB_pegSolitaire = array();

    }

    public function updateStats($dbconn, $username) {
        // query for the best scores for all four games, store results
        $this->overall = array('guessGame'=>$this->getOverall($dbconn, 'guessGame'),
            'pegSolitaire'=>$this->getOverall($dbconn,'pegSolitaire'),
            'fifteenPuzzle'=>$this->getOverall($dbconn, 'fifteenPuzzle'),
            'mastermind'=>$this->getOverall($dbconn, 'mastermind'));
        
        // query for user's best scores in each game, store results
        $this->PB_mastermind = $this->getPB($dbconn, 'mastermind', $username);
        $this->PB_guessGame = $this->getPB($dbconn, 'guessGame', $username);
        $this->PB_fifteenPuzzle = $this->getPB($dbconn, 'fifteenPuzzle', $username);
        $this->PB_pegSolitaire = $this->getPB($dbconn, 'pegSolitaire', $username);
    }

    public function getOverall($dbconn, $game) {
        if ($dbconn) {
            // get the best win based on minimum moves
            $query="SELECT * FROM wins WHERE game='".$game."' ORDER BY moves,time limit 1;";
            $best=pg_query($dbconn, $query);
            // if no plays exist for specified game, return
            if(pg_num_rows($best) == 0) {
                return "No plays yet.";
            }
            $row = pg_fetch_row($best);
            $userid = $row[0];
            $moves = $row[2];
            $seconds = $row[3];
            $time = $this->getTimeString($seconds);
            // query for the first name based on username
            $nameQuery = "SELECT first FROM users where username='".$userid."';";
            $nameResult = pg_query($dbconn, $nameQuery);
            $nameRow = pg_fetch_row($nameResult);
            $name = $nameRow[0];
            
            // construct our resulting string and return it
            $result = $name . ": " . $moves . " " . $this->getGameAction($game) . " in " . $time;
            return $result;
        }
        return "Could not connect to the database.";
    }
    # return arr
    public function getPB($dbconn, $game, $username) {
        if ($dbconn) {
            $returnArr = array();
            // query for best wins for given user, order by moves ascending
            $query="SELECT * FROM wins WHERE game='".$game."' AND userid='".$username."' ORDER BY moves,time;";
            $best=pg_query($dbconn, $query);
            $gameCount = 0;
            $row = pg_fetch_row($best);
            // while there are less than 3 results stored and there are results remaining:
            // store moves and time spent
            while ($gameCount<3 && $row != NULL) {
                $moves = $row[2];
                $seconds = $row[3];
                $time = $this->getTimeString($seconds);
                $returnArr[$gameCount] = $moves . " " . $this->getGameAction($game) . " in " . $time;
                $gameCount++;
                $row = pg_fetch_row($best);
            }
            // fill remaining space with blank values
            while (count($returnArr) < 3) {
                $returnArr[$gameCount] = "";
                $gameCount++;
            }
            return $returnArr;
            
        }
        return "Could not connect to the database.";
        
    }
    // convert an value in seconds into a minute, seconds format string
    public function getTimeString($seconds) {
        $seconds = (int) $seconds;
        $min = 0;
        if ($seconds >= 60) {
            while ($seconds >= 60) {
                $min++;
                $seconds = $seconds-60;
            }
            return $min . " minutes and " . $seconds . " seconds";
        } else {
            return $seconds . " seconds";
        }
    }

    // determine the proper 'move' noun based on game being played
    public function getGameAction($game) {
        if ($game == 'guessGame') {
            return 'guesses';
        } else if ($game == 'fifteenPuzzle') {
            return 'moves';
        } else if ($game == 'pegSolitaire') {
            return 'pegs left';
        } else {
            return 'rows';
        }
    }
	
}
?>
