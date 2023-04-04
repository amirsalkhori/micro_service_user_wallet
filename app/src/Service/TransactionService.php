<?php

namespace App\Service;

use App\Entity\Transaction;
use App\Entity\Wallet;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

final class TransactionService
{
    /**
     * @var WalletService
     */
    private $walletService;

    /** @var Client $redis */
    protected $redis;
    private LoggerInterface $logger;


    public function __construct(EntityManagerInterface $entityManager, WalletService $walletService, RedisManager $redis,
                                LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->walletService = $walletService;
        $this->redis = $redis;
        $this->logger = $logger;
    }

    /**
     * @param array $data
     * @return string
     */
    public function addMoney(array $data): string
    {
        /**
         * @var $walletRepo Wallet
         */
        $walletRepo = $this->entityManager->getRepository(Wallet::class)->findOneBy(['userId' => $data['userId']]);
        if (!$walletRepo){
            $wallet = $this->walletService->createWallet($data['userId'], $data['amount']);
        }else{
            $wallet = $this->walletService->updateWallet($data['userId'], $data['amount']);
        }

        $wallRedisKey = 'amount'.$data['userId'];
        $redis = $this->redis->client();
        $redis->set($wallRedisKey, $wallet->getAfterAmount());

        $transaction = $this->createTransaction($wallet, $data['amount']);
        $this->logger->info('TRANSACTIONS[SERVICE][ADD_MONEY]',
            ['msg' => ['userId'=> $transaction->getUserId(), 'referenceId' => $transaction->getReferenceId(), 'amount'=> $transaction->getAmount()]]);

        return $transaction->getReferenceId();
    }

    /**
     * @param Wallet $wallet
     * @param int $amount
     * @return Transaction
     */
    public function createTransaction(Wallet $wallet, int $amount): Transaction
    {
        $transaction = new  Transaction();
        $transaction->setUserId($wallet->getUserId());
        $transaction->setAmount($amount);
        $transaction->setReferenceId($this->getGUIDnoHash());
        $transaction->setWallet($wallet);
        $transaction->setCreatedAt(new \DateTime());
        $transaction->setUpdatedAt(new \DateTime());
        $this->entityManager->persist($transaction);
        $this->entityManager->flush();

        return $transaction;
    }

    function getGUIDnoHash(){
        mt_srand((double)microtime()*10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*",$charid);
        $c = implode("",$c);

        return substr($c,0,20);
    }

    /**
     * @return int
     */
    public function getTotalAmountTransaction(): int
    {
        $transactionRepo = $this->entityManager->getRepository(Transaction::class)->getTotalAmountTransaction();

        return $transactionRepo;
    }
}