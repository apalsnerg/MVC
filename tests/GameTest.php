<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GameTest extends TestCase
{
    /**
     * Tests that a game can be created.
     */
    public function testGameCreatable(): void
    {
        $game = new CardGame();
        $this->assertInstanceOf("\App\Cards\CardGame", $game);
    }

    /**
     * Tests that the fold method increases the turn variable.
     */
    public function testFoldTurnIncrement(): void
    {
        $game = new CardGame();
        $game->fold();
        $this->assertEquals($game->turn, 1);
        $game->fold();
        $this->assertEquals($game->turn, 2);
    }

    /**
     * Tests that the bank wins when scores are equal.
     */
    public function testEqualBankWins(): void
    {
        $game = new CardGame();
        $game->players[0]->score = 21;
        $game->players[1]->score = 21;
        $this->assertEquals($game->evalVictor(), "bank");
    }

    /**
     * Tests that the bank wins when it has more points.
     */
    public function testBankWinsIfMore(): void
    {
        $game = new CardGame();
        $game->players[0]->score = 17;
        $game->players[1]->score = 19;
        $this->assertEquals($game->evalVictor(), "bank");
    }

    /**
     * Tests that the bank wins when scores are equal.
     */
    public function testBankMoreButTooMuchLoses(): void
    {
        $game = new CardGame();
        $game->players[0]->score = 21;
        $game->players[1]->score = 22;
        $this->assertEquals($game->evalVictor(), "player");
    }

    /**
     * Tests that the bank wins when scores are equal.
     */
    public function testPlayerWinsIfMore(): void
    {
        $game = new CardGame();
        $game->players[0]->score = 20;
        $game->players[1]->score = 19;
        $this->assertEquals($game->evalVictor(), "player");
    }

    public function testBothLose(): void
    {
        $game = new CardGame();
        $game->players[0]->score = 22;
        $game->players[1]->score = 22;
        $this->assertEquals($game->evalVictor(), "none");
    }
}
