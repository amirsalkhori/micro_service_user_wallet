<?php

namespace App\Controller;

use App\Service\RedisManager;
use App\Service\WalletService;
use App\Validator\ValidatorService;
use App\Validator\WalletValidation;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolationList;

class WalletController extends AbstractController
{
    /**
     * @var WalletService
     */
    private $walletService;
    private RedisManager $redis;
    private ValidatorService $validator;

    public function __construct(WalletService $walletService, RedisManager $redis, ValidatorService $validator)
    {
        $this->walletService = $walletService;
        $this->redis = $redis;
        $this->validator = $validator;
    }

    /**
     * @Route("/api/get-balance", methods={"POST"}, name="get-balance")
     */
    public function getBalance(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        /** @var ConstraintViolationList $violations */
        $violations = $this->validator->validateBy(
            new WalletValidation(),
            $data
        );
        if (count($violations) > 0) {
            return new JsonResponse(['error' => $violations[0]->getMessage()], 400);
        }


        if (!$data['userId']){
            throw new BadRequestException('UserId is require', 400);
        }
        $wallRedisKey = 'amount'.$data['userId'];
        $redis = $this->redis->client();
        $redisKey = $redis->get($wallRedisKey);
        if ($redisKey){
            $userBalance = $redisKey;
        }else{
            $userBalance = $this->walletService->getBalance($data['userId']);
        }

        return new JsonResponse(['balance' => $userBalance], 200);
    }
}