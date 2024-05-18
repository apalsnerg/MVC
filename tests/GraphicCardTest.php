<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GraphicCardTest extends TestCase
{
    public function testCreateRandomGraphicCard(): void
    {
        $card = new GraphicCard();
        $this->assertInstanceOf("\App\Cards\GraphicCard", $card);
    }

    public function testGetGraphic(): void
    {
        $card = new GraphicCard("7", "♠️");
        $graphic = $card->graphic();
        $this->assertEquals($graphic, "[7♠️]");
    }
}
