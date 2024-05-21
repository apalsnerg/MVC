<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

$suits = ["♣️", "♦️", "♥️", "♠️"];
$values = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
/**
 * Test cases for class Bank.
 */
class BankTest extends TestCase
{
    /**
     * Tests that players and banks can be created.
     */
    public function testCreateBank(): void
    {
        $bank = new Bank();
        $this->assertInstanceOf("\App\Cards\Bank", $bank);
    }

    public function testBankEvalsDraw(): void
    {
        $bank = new Bank();
        $bank->score = 17;
        $this->assertEquals($bank->handEval(), "draw");
    }

    public function testBankEvalsFold(): void
    {
        $bank = new Bank();
        $bank->score = 19;
        $this->assertEquals($bank->handEval(), "fold");
    }

    public function testBankEvalAceHigh(): void
    {
        $bank = new Bank();
        $bank->score = 9;
        $card = new GraphicCard("A", "♥️");
        $bank->evalCard($card);
        $this->assertEquals($bank->getPoints(), 20);
    }

    public function testBankFoldsIfHighScore(): void
    {
        $bank = new Bank();
        $bank->score = 9;
        $card = new GraphicCard("A", "♥️");
        $res = $bank->evalCard($card);
        $this->assertEquals($res, "fold");
    }
    
    public function testBankEvalAceLow(): void
    {
        $bank = new Bank();
        $bank->score = 18;
        $card = new GraphicCard("A", "♥️");
        $bank->evalCard($card);
        $this->assertEquals($bank->getPoints(), 19);
    }

    public function testBankDrawsIfLowScore(): void
    {
        $bank = new Bank();
        $bank->score = 3;
        $card = new GraphicCard("7", "♥️");
        $res = $bank->evalCard($card);
        $this->assertEquals($res, "draw");
    }

    public function testBankAcceptsLetterCards():void
    {
        $bank = new Bank();
        $bank->score = 10;
        $card = new GraphicCard("Q", "♥️");
        $res = $bank->evalCard($card);
        $this->assertEquals($bank->getPoints(), 20);
        $this->assertEquals($res, "fold");
    }
}
