<?php
require_once("Game.php");

class GuessGame extends Game{
	public $secretNumber = 5;
	public $history = array();
	public $state = "";

	public function __construct() {
			parent::__construct();
			// generate the solution
			$this->secretNumber = rand(1,10);
    	}
	
	public function play($guess){
		// start the timer when a guess is made, if necessary
		$this->startTimer();

		// determine state of guess
		$this->moves++;
		if($guess>$this->secretNumber){
			$this->state="too high";
		} else if($guess<$this->secretNumber){
			$this->state="too low";
		} else {
			$this->state="correct";
		}
		$this->history[] = "Guess #$this->moves was $guess and was $this->state.";
	}
	//return the current state
	public function getState(){
		return $this->state;
	}

	//return true if win
	public function isWin() {
		if ($_SESSION['game']->getState()=="correct") {
			return true;
		}
		return false;
	}
	//get the stat of game result
	public function getStat() {
		return $this->moves;
	}
}
?>
