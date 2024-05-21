<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertGreaterThan;
use function PHPUnit\Framework\assertInstanceOf;

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
     * Tests that the bank wins if the player has more than 21 points and the bank less than 22.
     */
    public function testBankWinsPlayerTooMuch(): void
    {
        $game = new CardGame();
        $game->players[0]->score = 22;
        $game->players[1]->score = 20;
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

    /**
     * Tests that both people lose if both scores are above 21.
     */
    public function testBothLose(): void
    {
        $game = new CardGame();
        $game->players[0]->score = 22;
        $game->players[1]->score = 22;
        $this->assertEquals($game->evalVictor(), "none");
    }

    /**
     * Tests that the bank takes its turns and does not stop unless it has above 17 points.
     */
    public function testBankTurnRandom(): void
    {
        $game = new CardGame();
        $game->bankTurn();
        $bank = $game->players[1];
        $this->assertGreaterThan(16, $bank->getPoints());
    }

    /**
     * Tests that cards are added to the Bank's hand during the TakeTurn method.
     */
    public function testBankTurnAddsCards(): void
    {
        $game = new CardGame();
        $game->bankTurn();
        $bank = $game->players[1];
        $this->assertNotEmpty($bank->hand);
    }
}
