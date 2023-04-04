<?php

namespace tests;

use App\Entity\Transaction;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    private $model;

    /**
     * @before
     */
    public function setUp(): void
    {
        $wallet = new Wallet();
        $wallet->setUserId(1);
        $wallet->setBeforeAmount(0.0);
        $wallet->setAfterAmount(0.0);
        $wallet->setEffectiveAmount(0.0);

        $transaction = new Transaction();
        $transaction->setWallet($wallet);
        $transaction->setUserId(1);
        $transaction->setReferenceId('12312312312');
        $transaction->setAmount(0.0);

        $this->model = $transaction;
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Transaction::class, $this->model);
    }

    public function testFailure(): void
    {
        $this->assertContains($this->model->getUserId(), [1, 2, 3]);
        $this->assertStringContainsString($this->model->getReferenceId(), '12312312312');
    }
}