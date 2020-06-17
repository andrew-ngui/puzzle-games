<?php
require_once("Game.php");

class Mastermind extends Game{
	public $solution = array(); // 0->3
	public $guesses = array(); // 0->39, NULL for empty
	public $totalRows = 10;
	public $hint = array(); //0->39. NULL=empty, 0=black, 1=white
	public $lastSol = array(NULL,NULL,NULL,NULL);

	public function __construct() {
		parent::__construct();
			// generate solution
			for($x=0; $x<=3; $x++) {
				$this->solution[$x] = rand(0,5);
			}
			// populate default values in the array
			for($x=0; $x<=39; $x++) {
				$this->guesses[$x] = NULL;
				$this->hint[$x] = NULL;
			}

    	}
	
	public function insert($num) {
		if ($this->isGameOver()) {
			return false;
		}
		// start timer, if necessary
		$this->startTimer();
		// find next available index in current row, insert the value
		for ($i = $this->moves * 4; $i < $this->moves*4+4; $i++) {
			if ($this->guesses[$i] === NULL) {
				$this->guesses[$i] = (int)$num;
				return true;
			}
		}
		return false;
	}
	
	// at current row; clear the values currently stored
	public function delete() {
		for ($i = $this->moves * 4; $i < $this->moves*4+4; $i++) {
			$this->guesses[$i] = NULL;
		}
	}
	// determine if we have enough values to do a full check
	public function isCheck() {
		if($this->moves*4+3 < ($this->totalRows)*4 
		&& $this->guesses[$this->moves*4+3] === NULL) {
			return false;
		}
		return true;
	}

	public function play($guess) {
		if ($guess == 'check') {
			$this->check();
		} else if ($guess == 'delete') {
			$this->delete();
		} else {
			$this->insert($guess);
		}
	} 

	// compare guessed sequence to the solution
	public function check() {
		if(!$this->isCheck()) {
			return false;
		}
		// temporarily store our sequences so we can modify as needed
		$tempGuess = array_slice($this->guesses, $this->moves*4, 4, false);
		$tempSol = array_slice($this->solution, 0, 4, false);
		$tempHint = array();

		// if we find any matching values at indices: add a black circle to our hints
		// remove the values as they are matched
		for ($x=0; $x<=3; $x++) {
			if ($tempGuess[$x] === $tempSol[$x]) {
				$tempGuess[$x] = NULL;
				$tempSol[$x] = NULL;
				array_push($tempHint, 1);
			}
		}
		
		// check the remaining values to see if they exist in the other sequence
		// if so, add a white circle 
		for ($x=0; $x<=3; $x++) {
			$token = $tempGuess[$x];
			for ($i=0; $i<=3;$i++) {
				if ($tempSol[$i] !== NULL && $tempSol[$i] === $token) {
					array_push($tempHint, 2);
					$tempSol[$i] = NULL;
					break;
				}
			}
		}

		// fill the rest of our size-4 hint array with empty values
		while (count($tempHint) < 4) {
			array_push($tempHint, NULL);
		}
		
		// update our stored total hint array with our calculated values
		for ($i = 0;$i<=3;$i++) {
			$this->hint[4*$this->moves+$i]=$tempHint[$i];
		}
		// store last solution temporarily for win checking
		$this->lastSol = $tempHint;

		$this->moves++;
		return true;
	}

	// check if the last 4 hint values if we had a total match of sequences
	public function isWin() {
		foreach ($this->lastSol as $key=>$value) {
			if ($value != 1) {
				return false;
			}
		}
		return true;
	}
	
	// determine if game is over: no more guesses or game is won
	public function isGameOver() {
		if ($this->isWin() || $this->moves === $this->totalRows){
			return true;
		}
		return false;
	}
	public function getStat() {
		return $this->moves;
	}

}

?>
