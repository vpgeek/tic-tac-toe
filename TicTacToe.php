<?php

class TicTacToe {

    public array $board;
    public int $size;
    public string $player1; // X
    public string $player2; // O
    public bool $playerTurn; // true => player1, false => player2
    public int $totalMoves;
    public array $rowString;
    public array $colString;
    public string $diagonalString;
    public string $reverseDiagonalString;

    public function __construct($size, $playerTurn) {
        // initialize game configuration
        $this->player1 = 'X';
        $this->player2 = 'O';
        $this->totalMoves = 0;
        $this->size = $size;
        $this->playerTurn = $playerTurn;

        // initialize game rules
        for ($i=0; $i<$this->size; $i++) {
            $this->rowString[$i] = '';
            $this->colString[$i] = '';
        }
        $this->diagonalString = '';
        $this->reverseDiagonalString = '';

        // initialize game board
        for ($i=0; $i<$this->size; $i++) {
            for ($j=0; $j<$this->size; $j++) {
                $this->board[$i][$j] = '';
            }
        }
    }

    public function move($row, $col) {
        if ($this->board[$row][$col] != '') {
            return 'Invalid move!';
        }

        $currentPlayer = ($this->playerTurn == true) ? $this->player1 : $this->player2;
        $this->totalMoves++;
        $this->board[$row][$col] = $currentPlayer;
        $this->rowString[$row] .= $currentPlayer;
        $this->colString[$col] .= $currentPlayer;
        if ($row == $col) {
            $this->diagonalString .= $currentPlayer;
        }
        if (($row+$col) == ($this->size-1)) {
            $this->reverseDiagonalString .= $currentPlayer;
        }

        $gameStatus = $this->checkRules($currentPlayer);
        if ($gameStatus) {
            return $gameStatus;
        }

        // switch player if game should be continued
        $this->playerTurn = ! $this->playerTurn;
    }

    public function checkRules($currentPlayer) {
        // check if current move is a winning move
        $winningString = $this->getWinningStringForPlayer($currentPlayer);
        if ($this->totalMoves <= $this->size * $this->size) {
            for ($i=0; $i<$this->size; $i++) {
                if (($this->rowString[$i] == $winningString) || ($this->colString[$i] == $winningString)) {
                    return 'Player ' . $currentPlayer . ' Won!';
                }
            }

            if (($this->diagonalString == $winningString) || ($this->reverseDiagonalString == $winningString)) {
                return 'Player ' . $currentPlayer . ' Won!';
            }

            if ($this->totalMoves == $this->size * $this->size) {
                return 'Game was draw';
            }
        }
        return false;
    }

    public function getWinningStringForPlayer($player) {
        $winningString = '';
        for ($i=0; $i<$this->size; $i++) {
            $winningString .= $player;
        }
        return $winningString;
    }

    public function printBoard() {
        for ($i=0; $i<$this->size; $i++) {
            echo '<br/>|';
            for ($j=0; $j<$this->size; $j++) {
                echo '&nbsp;' . $this->board[$i][$j] . '&nbsp;|';
            }
        }
    }
}

$tictactoe = new TicTacToe(3, true); // player X plays first
$inputArray = [ [0, 0], [0, 1], [1, 1], [1, 2], [2, 2], [0, 2], [2, 0] ]; // winning game
// $inputArray = [ [0, 0], [0, 1], [0, 2], [1, 1], [1, 0], [1, 2], [2, 1], [2, 0], [2, 2] ]; // draw game

foreach ($inputArray as $input) {
    $status = $tictactoe->move($input[0], $input[1]);
    if (isset($status)) {
        echo $status;
        break;
    }
}
$tictactoe->printBoard();
