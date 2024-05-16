<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class CardTest extends TestCase
{
    public function testCreateRandomCard() {
        $card = new GraphicCard();
        $this->assertInstanceOf("\App\Cards\GraphicCard", $card);
    }

    public function testCreateGivenCard() {
        $suit = "♥️";
        $value = "10";
        $card = new GraphicCard($value, $suit);
        $this->assertInstanceOf("\App\Cards\GraphicCard", $card);
        $this->assertEquals($card->getSuit(), "♥️");
        $this->assertEquals($card->getValue(), "10");
    }

    public function testStringToCardNice() {
        
    }
}