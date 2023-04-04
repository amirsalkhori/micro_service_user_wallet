<?php

namespace tests;

use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    private $model;

    /**
     * @before
     */
    public function setUp(): void
    {
        $wallet = new Wallet();
        $wallet->setUserId(1);
        $wallet->setBeforeAmount(100);
        $wallet->setAfterAmount(200);
        $wallet->setEffectiveAmount(50);

        $this->model = $wallet;
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Wallet::class, $this->model);
    }

    public function testObject()
    {
        $this->assertEquals(1, $this->model->getUserId());
        $this->assertEquals(200, $this->model->getAfterAmount());
        $this->assertEquals(50, $this->model->getEffectiveAmount());
        $this->assertIsInt(1, $this->model->getUserId());
        $this->assertIsInt(1, $this->model->getUserId());
    }
}