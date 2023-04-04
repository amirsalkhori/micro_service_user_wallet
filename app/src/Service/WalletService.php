<?php

namespace App\Service;

use App\Entity\Wallet;
use Doctrine\ORM\EntityManagerInterface;

final class WalletService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $userId
     * @return float|null
     */
    public function getBalance(int $userId): ?float
    {
        /**
         * @var $walletRepo Wallet
         */
        $walletRepo = $this->entityManager->getRepository(Wallet::class)->findOneBy(['userId' => $userId]);
        $amount = null;
        if ($walletRepo){
            $amount = $walletRepo->getAfterAmount();
        }

        return $amount;
    }

    /**
     * @param int $userId
     * @param float $amount
     * @return Wallet
     */
    public function createWallet(int $userId, float $amount): Wallet
    {
        $wallet = new Wallet();
        $wallet->setUserId($userId);
        $wallet->setBeforeAmount(0.0);
        $wallet->setAfterAmount($amount);
        $wallet->setEffectiveAmount($amount);
        $wallet->setCreatedAt(new \DateTime());
        $wallet->setUpdatedAt(new \DateTime());
        $this->entityManager->persist($wallet);
        $this->entityManager->flush();

        return $wallet;
    }

    /**
     * @param int $userId
     * @param float $amount
     * @return Wallet
     */
    public function updateWallet(int $userId, float $amount): Wallet
    {
        /**
         * @var $wallet Wallet
         */
        $wallet = $this->entityManager->getRepository(Wallet::class)->findOneBy(['userId' => $userId]);
        $wallet->setBeforeAmount($wallet->getAfterAmount());
        $wallet->setAfterAmount($wallet->getAfterAmount() + $amount);
        $wallet->setEffectiveAmount($amount);
        $wallet->setUpdatedAt(new \DateTime());
        $this->entityManager->persist($wallet);
        $this->entityManager->flush();

        return $wallet;
    }
}