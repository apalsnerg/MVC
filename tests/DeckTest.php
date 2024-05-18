<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DeckTest extends TestCase
{
    /**
     * Tests that a deck can be created.
     */
    public function testCreatedeck(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Cards\DeckOfCards", $deck);
    }

    /**
     * Tests that all graphics are returned successfully.
     */
    public function testShuffle(): void
    {
        $deck = new DeckOfCards();
        $shuffledDeck = clone $deck;
        $shuffledDeck->shuffle();
        $deckList = $deck->returnAllCards();
        $shuffledList = $shuffledDeck->returnAllCards();
        $shuffled = false;

        // Theoretically not a complete test, but it is statistically not possible for the
        // deck to be shuffled and remain the same, as the probability is 52 factorial.
        // Unknown but possible that that is forbidden by the PHP shuffle() function anyway.
        for($i = 0; $i < $deck->getLength(); $i++) {
            if ($deckList[$i] != $shuffledList[$i]) {
                $shuffled = true;
            }
        }

        $this->assertTrue($shuffled);
    }

    /**
     * Tests that cards can be added to the deck.
     */
    public function testDrawNegative(): void
    {
        $deck = new DeckOfCards();
        $cards = $deck->draw(-1);
        $this->assertEquals($cards, []);
    }

    /**
     * Tests that passing too many numbers to the constructor does not break it.
     */
    public function testDrawTooManyCards(): void
    {
        $deck = new DeckOfCards();
        $deck->draw(10000000000000000);
        $this->assertEquals($deck->returnAllCards(), []);
    }
}
