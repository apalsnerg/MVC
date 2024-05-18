<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

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
        $bank->evalAce();
        $this->assertEquals($bank->getPoints(), 20);
    }

    public function testBankEvalAceLow(): void
    {
        $bank = new Bank();
        $bank->score = 18;
        $bank->evalAce();
        $this->assertEquals($bank->getPoints(), 19);
    }
}
