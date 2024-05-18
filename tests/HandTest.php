<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class HandTest extends TestCase
{
    /**
     * Tests that a hand can be created.
     */
    public function testCreateHand(): void
    {
        $hand = new CardHand();
        $this->assertInstanceOf("\App\Cards\CardHand", $hand);
    }

    /**
     * Tests that all graphics are returned successfully.
     */
    public function testGetGraphics(): void
    {
        $hand = new CardHand();
        $cardGraphics = $hand->getCardGraphics();
        $cards = $hand->getCards();
        $length = count($cards);
        for($i = 0; $i < $length; $i++) {
            $this->assertEquals($cardGraphics[$i], $cards[$i]->graphic());
        }
    }

    /**
    * Tests that cards can be retrieved.
    */
    public function testGetCards(): void
    {
        $card = new GraphicCard("8", "♦️");
        $hand = new CardHand(0);
        $hand->addCard($card);
        $retrieved = $hand->getCards()[0];
        $this->assertEquals($card, $retrieved);
    }

    /**
     * Tests that cards can be added to the hand.
     */
    public function testAddCards(): void
    {
        $hand = new CardHand(0);
        $card = new GraphicCard("8", "♦️");
        $hand->addCard($card);
        $this->assertTrue((in_array($card, $hand->getCards())));
    }

    /**
     * Tests that negative amount of cards creates 0 cards.
     */
    public function testAddNegativeCards(): void
    {
        $hand = new CardHand(-1);
        $this->assertEquals($hand->getCards(), []);
    }
}
