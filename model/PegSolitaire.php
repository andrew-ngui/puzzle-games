<?php
require_once("Game.php");

class PegSolitaire extends Game {
    public $size;
    public $num;
    public $pegs = array();
    public $start; // the first click
    public $end; // the 2nd click
    public $rows;
    public $cols;
    public $pegsLeft;
    

    // game board: 
    // 0 .... 6
    // .      .
    // .      .
    // 42 .. 48

    public function __construct() {
        parent::__construct();
        $this->start = NULL;
        $this->end = NULL;
        // dimensions of our board
        $this->rows = 7;
        $this->cols = 7;
        $this->pegsLeft = 0;
        // for simplicity of move calculating, the array is filled with values that are not applicable for clicking. This is due to the shape of the game board.
        // 0 = empty, 1 = filled, 2 = not usable
        $this->pegs = array(
            array(2, 2, 1, 1, 1, 2, 2), 
            array(2, 2, 1, 1, 1, 2, 2), 
            array(1, 1, 1, 1, 1, 1, 1), 
            array(1, 1, 1, 0, 1, 1, 1),
            array(1, 1, 1, 1, 1, 1, 1), 
            array(2, 2, 1, 1, 1, 2, 2),
            array(2, 2, 1, 1, 1, 2, 2)
        );
    }



    // handler for button being clicked
    public function play($peg) {
        // start timer if necessary
        $this->startTimer();
        // if a starting peg is not already selected
        if ($this->start == NULL) {
            if ($this->setSelected($peg) != false) {
                $this->start = $peg;
            }
        } else {
            // set our destination, make the move
            $this->end = $peg;
            // if the move was a valid move, increment moves made
            $this->move();
            // clear the attributes for the next move
            $this->start = NULL;
            $this->end = NULL;
        }
        return;
    }

    // update board and to indicate the peg is selected by player
    // return true if valid selection, return false if not
    public function setSelected($index) {
        $coords = $this->indexToCoords($index);
        $row = $coords[0];
        $col = $coords[1];
        if ($this->pegs[$row][$col] != 0) {
            $this->pegs[$row][$col] = 1;
            return true;
        }
        return false;
    }
    
    // return an array with x,y coordinate based on indices 0->48
    public function indexToCoords($index) {
        $row = 0;
        $num = $index;
        while($num >= $this->rows) {
            $num = $num - $this->rows;
            $row++;
        }
        $col = $index % $this->cols;
        return array($row, $col);
    }


    // check that the move was valid: if valid, return the peg's coords that gets removed. if not, return false
    public function IsValidMove($start, $end, $arr) {
        // store in variables for clarity
        // arr flag indicates need for conversion to array
        if ($arr == true) {
            $startCoord = $this->indexToCoords($start);
            $endCoord = $this->indexToCoords($end);
        } else {
            $startCoord = $start;
            $endCoord = $end;
        }

        $start_row = $startCoord[0];
        $start_col = $startCoord[1];
        $end_row = $endCoord[0];
        $end_col = $endCoord[1];

        // default values
        $new_row = $end_row;
        $new_col = $end_col;

        // check were in bounds
        if ($start_row < 0 || $start_col < 0 || $end_row < 0 || $end_col < 0 || $end_row > 6 || $end_col > 6) {
            return false;
        }

        // check valid selection
        if (($this->pegs[$start_row][$start_col] != 1) || ($this->pegs[$end_row][$end_col] != 0)) {
            return false;
        }

        
        // going left
        if (($start_row == $end_row) && ($end_col == $start_col -2)) {
            $new_col = $end_col +1;
        }
        // going right
        else if (($start_row == $end_row) && ($end_col == $start_col +2)) {
            $new_col = $start_col+1;
        }
        // going up
        else if (($start_col == $end_col) && ($end_row == $start_row -2)) {
            $new_row = $end_row +1;
        }
        // going down
        else if (($start_col == $end_col) && ($start_row == $end_row -2)) {
            $new_row = $start_row +1;
        }
        // going up-left
        else if (($end_row == $start_row -2) && ($end_col == $start_col -2)) {
            $new_row = $end_row +1;
            $new_col = $end_col +1;
        }
        // going up-right
        else if (($end_row == $start_row -2) && ($end_col == $start_col +2)) {
            $new_row = $end_row +1;
            $new_col = $start_col +1;
        }
        // going down-left
        else if (($end_row == $start_row +2) && ($end_col == $start_col -2)) {
            $new_row = $start_row +1;
            $new_col = $end_col +1;
        }
        // going down-right
        else if (($end_row == $start_row +2) && ($end_col == $start_col +2)) {
            $new_row = $start_row +1;
            $new_col = $start_col +1;
        } else { // not valid move
            return false;
        }
        // check that there is a peg actually being hopped over
        if ($this->pegs[$new_row][$new_col] != 1) {
            return false;
        }
        // return our peg being hopped over
        return array($new_row, $new_col);
    }


    // move the pegs stored in attributes
    public function move() {
        $rmPeg = $this->isValidMove($this->start, $this->end, true);
        if ($rmPeg != false) {
            // remove the peg that was hopped over
            $this->pegs[$rmPeg[0]][$rmPeg[1]] = 0;
            
            // put moved peg in ending position
            $endPegCoords = $this->indexToCoords($this->end);
            $this->pegs[$endPegCoords[0]][$endPegCoords[1]] = 1;

            // remove peg in starting position
            $startPegCoords = $this->indexToCoords($this->start);
            $this->pegs[$startPegCoords[0]][$startPegCoords[1]] = 0;

            $this->moves++;
        }   
    }

    // check if any given peg can be moved in any of the 8 directions
    public function anyPossibleMoves($start) {
        $row = $start[0];
        $col = $start[1];
        return ($this->isValidMove($start,array($row+2, $col), false) // down
            || $this->isValidMove($start,array($row-2, $col), false) // up
            || $this->isValidMove($start,array($row, $col+2), false) // right
            || $this->isValidMove($start,array($row, $col-2), false) // left
            || $this->isValidMove($start,array($row-2, $col-2), false) // up left
            || $this->isValidMove($start,array($row-2, $col+2), false) // up right     
            || $this->isValidMove($start,array($row+2, $col-2), false) // down left
            || $this->isValidMove($start,array($row+2, $col+2), false) // down right
        );
    }

    // iterate all remaining pegs to see if they can be moved
    public function areMovesLeft() {
        $this->pegsLeft = 0;
        for($row1 = 0; $row1 < $this->rows; $row1++) {
            for($col1= 0; $col1 < $this->cols; $col1++) {
                if ($this->pegs[$row1][$col1] == 1) {
                    $this->pegsLeft++;
                    $peg = array($row1, $col1);
                    if ($this->anyPossibleMoves($peg)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    public function isWin() {
        if ($_SESSION['game']->areMovesLeft()== false) {
            return true;
        }
        return false;
    }
    public function getStat() {
        return $this->pegsLeft;
    }

}
?>