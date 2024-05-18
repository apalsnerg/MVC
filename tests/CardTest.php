<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Test cases for class Guess.
 */
class CardTest extends TestCase
{
    public function testCreateRandomBasicCard(): void
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Cards\Card", $card);
    }

    public function testCreateGivenCard(): void
    {
        $value = "10";
        $suit = "♥️";
        $card = new Card($value, $suit);
        $this->assertEquals($card->getSuit(), "♥️");
        $this->assertEquals($card->getValue(), "10");
    }

    public function testCreateCardInvalidValueStr(): void
    {
        $this->expectException(TypeError::class);
        $suit = "♣️";
        $valueInvalidStr = "11";
        $card = new Card($valueInvalidStr, $suit);
    }

    public function testCreateCardInvalidSuitStr(): void
    {
        $this->expectException(TypeError::class);
        $value = "5";
        $suitInvalidStr = "1";
        $card = new Card($value, $suitInvalidStr);
    }

    public function testGetValue(): void
    {
        $card = new Card("10", "♥️");
        $value = $card->getValue();
        $this->assertEquals($value, "10");
    }

    public function testGetSuit(): void
    {
        $card = new Card("2", "♠️");
        $suit = $card->getSuit();
        $this->assertEquals($suit, "♠️");
    }
}
