<?php
/**
 * Tic Tac Toe Game - Approach II
 *  
 */

/*
Input Samples

[ [0, 0], [0, 1], [1, 1], [1, 2], [2, 2], [0, 2], [2, 0] ] // winning game
[ [0, 0], [0, 1], [0, 2], [1, 0], [1, 1], [1, 2], [2, 0], [2, 1], [2, 2] ] // winning game
[ [0, 0], [0, 1], [0, 2], [1, 1], [1, 0], [1, 2], [2, 1], [2, 0], [2, 2] ] // draw game

*/

class TicTacToeII {

    public array $board;
    public int $size;
    public string $player1 = 'X';
    public string $player2 = 'O';
    public bool $playerTurn; // true => player1, false => player2
    public int $moveCount = 0;

    public function __construct($size, $playerTurn) {
        $this->size = $size;
        $this->playerTurn = $playerTurn;

        // initialize game board
        for ($i=0; $i<$this->size; $i++) {
            for ($j=0; $j<$this->size; $j++) {
                $this->board[$i][$j] = '';
            }
        }
    }

    public function move($row, $col) {
        // check for invalid move
        if ($this->board[$row][$col] != '') {
            return 'Invalid move!';
        }

        // make move
        $currentPlayer = ($this->playerTurn == true) ? $this->player1 : $this->player2;
        $this->board[$row][$col] = $currentPlayer;
        $this->moveCount++;

        // check for winning rules

        // check row
        for ($i=0; $i<$this->size; $i++) {
            if ($this->board[$i][$col] != $currentPlayer) {
                break;
            }
            if ($i == $this->size-1) {
                return 'Player ' . $currentPlayer . ' Won!';
            }
        }

        // check col
        for ($i=0; $i<$this->size; $i++) {
            if ($this->board[$row][$i] != $currentPlayer) {
                break;
            }
            if ($i == $this->size-1) {
                return 'Player ' . $currentPlayer . ' Won!';
            }
        }

        // check diagonal
        if ($row == $col) {
            for ($i=0; $i<$this->size; $i++) {
                if ($this->board[$i][$i] != $currentPlayer) {
                    break;
                }
                if ($i == $this->size-1) {
                    return 'Player ' . $currentPlayer . ' Won!';
                }
            }
        }

        // check reverse diagonal
        if ($row+$col == $this->size-1) {
            for ($i=0; $i<$this->size; $i++) {
                if ($this->board[$i][($this->size-1)-$i] != $currentPlayer) {
                    break;
                }
                if ($i == $this->size-1) {
                    return 'Player ' . $currentPlayer . ' Won!';
                }
            }
        }

        // check draw
        if ($this->moveCount == $this->size*$this->size) {
            return 'Game ends draw';
        }

        // switch player if game should be continued
        $this->playerTurn = ! $this->playerTurn;
    }

    public function printBoard() {
        for ($i=0; $i<$this->size; $i++) {
            echo '<br/>|';
            for ($j=0; $j<$this->size; $j++) {
                echo ' ' . (($this->board[$i][$j] == '') ? '&nbsp;&nbsp;' : $this->board[$i][$j]) . ' |';
            }
        }
    }
}

$tictactoe = new TicTacToeII(3, true); // player X plays first
$inputArray = [ [0, 0], [0, 1], [1, 1], [1, 2], [2, 2], [0, 2], [2, 0] ];
foreach ($inputArray as $input) {
    $status = $tictactoe->move($input[0], $input[1]);
    if (isset($status)) {
        echo $status;
        break;
    }
}
$tictactoe->printBoard();
