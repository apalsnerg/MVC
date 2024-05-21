<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Test cases for class Player.
 */
class PlayerTest extends TestCase
{
    /**
     * Tests that players and banks can be created.
     */
    public function testCreatePlayer(): void
    {
        $player = new Player();
        $this->assertInstanceOf("\App\Cards\Player", $player);
    }

    /**
     * Tests that a player cannot be created with an incorrect identifier.
     */
    public function testCreatePlayerWrongIdentifier(): void
    {

        $this->expectException(TypeError::class);
        $player = new Player(3.24);
    }

    /**
     * Tests that points can be added to a player.
     */
    public function testAddPoints(): void
    {
        $player = new Player();

        $cardOne = new GraphicCard("7", "♠️");
        $player->addPoints($cardOne);
        $this->assertEquals($player->getPoints(), 7);

        $cardTwo = new GraphicCard("J", "♣️");
        $player->addPoints($cardTwo);
        $this->assertEquals($player->getPoints(), 17);
    }

    /**
     * Tests that the ace function works properly for low score.
     */
    public function testAceLow(): void
    {
        $player = new Player();
        $player->ace();
        $this->assertEquals($player->getPoints(), 1);
    }

    /**
     * Tests that the ace function works properly for high score.
     */
    public function testAceHigh(): void
    {
        $player = new Player();
        $player->ace("high");
        $this->assertEquals($player->getPoints(), 11);
    }

    /**
     * Tests that giving an invalid option for ace raises an exception.
     */
    public function testAceWrongStringException(): void
    {
        $this->expectException(TypeError::class);
        $player = new Player();
        $player->ace("test");
    }
}
