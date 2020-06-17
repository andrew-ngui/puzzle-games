<?php

class Game {
    public $winRecorded; // boolean for when game is recorded when it is won
    public $started; // indicating player has made a move
    public $time; // storing the time on win
    public $moves;
    
    public function __construct() {
        $this->winRecorded = false;
        $this->started = false;
        $this->time = 0;
        $this->moves = 0;
        
    }

    // if the initial time is not yet recorded, start it
    public function startTimer() {
        if ($this->started == NULL) {
			$this->started = microtime(true);
		}
    }

    // call when game is won: calculate time difference on win
    public function getTime() {
		$current = microtime(true);
		$this->time = $current - $this->started;
		return $this->time;
	}

    // set recorded flag to true
    public function setWin() {
		$this->winRecorded = true;
  }

}

?>
