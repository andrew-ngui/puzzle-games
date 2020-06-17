<?php
require_once("Game.php");

class FifteenPuzzle extends Game {
    
    public $size ;
    public $num;
    public $tiles;
    public $pos;

    public function __construct() {
        $this->size = 4; // 4x4 grid
        $this->num = $this->size * $this->size;
        $this->shuffle(); // generate the board

        // if the game is not solvable with the generated board, try again
        while(!$this->isSolvable()){
            $this->shuffle();
        }
        parent::__construct();
        
    }
    //Compute the invariant count of the board
    private function getInvCount() {
        $inversion = 0;
        for ($i = 0; $i < $this->num-1; $i++) {
            for ($j = $i + 1; $j < $this->num;$j++) {
                if ($this->tiles[$i] > $this->tiles[$j] && $this->tiles[$j]!=0) {
                    $inversion++;
                }
            }
        }
        return $inversion;
    }

    // randomize the sequence of the board
    private function shuffle() {
        $this->tiles = range(0,$this->num-1);
        shuffle($this->tiles);
        $this->pos = array_search(0,$this->tiles,true);


    }

    // check that the game is solvable in its curent state
    private function isSolvable() {
        if ((int)(15-$this->pos)/4 % 2 == 0) {
            if ($this->getInvCount()%2==0) {
                return true;
            }
        } else {
            if ($this->getInvCount()%2==1) {
                return true;
            }
        }

        return false;
    }

    // check equality of the current game state and proper sequence for a solved game
    private function isGameOver() {
        $complete = range(1,$this->num-1);
        array_push($complete,0);
        if ($this->tiles === $complete) {
            return true;
        }
        return false;
    }
    // return true if win
    public function isWin() {
        if ($this->isGameOver()==true) {
            return true;
        }
        return false;
    }
    
    // check that the user's selected move is valid (there is a blank spot adjacent)
    private function isValidMove($id) {
        if ($id==$this->pos) {
            return false;
        }
        if ($id+$this->size==$this->pos) {
            return true;
        }
        if ($id-$this->size==$this->pos) {
            return true;
        }
        if ($id+1==$this->pos && ($id+1)%4!=0) {
            return true;
        }
        if ($id-1==$this->pos && ($id-1)%4!=3) {
            return true;
        }
        return false;
    }

    // handle the button click, execute if conditions are met
    public function play($id) {
        if (!$this->isGameOver() && $this->isValidMove($id)) {
            $this->tiles[$this->pos] = $this->tiles[$id];
            $this->tiles[$id] = 0;
            $this->pos = $id;
            $this->moves++;
            // start timer if necessary
            $this->startTimer();
        }
    }

    //get the stat of the game result
    public function getStat() {
        return $this->moves;
    }
}

?>
