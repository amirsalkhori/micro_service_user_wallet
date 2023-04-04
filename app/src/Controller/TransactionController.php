<?php

namespace App\Controller;

use App\Service\TransactionService;
use App\Validator\TransactionValidation;
use App\Validator\ValidatorService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolationList;

class TransactionController extends AbstractController
{

    /**
     * @var TransactionService
     */
    private $transaction;
    private ValidatorService $validator;

    public function __construct(TransactionService $transaction, ValidatorService $validator)
    {
        $this->transaction = $transaction;
        $this->validator = $validator;
    }

    /**
     * @Route("/api/add-money", methods={"POST"}, name="add-money")
     */
    public function addMoney(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        /** @var ConstraintViolationList $violations */
        $violations = $this->validator->validateBy(
            new TransactionValidation(),
            $data
        );
        if (count($violations) > 0) {
            return new JsonResponse(['error' => $violations[0]->getMessage()], 400);
        }

        $transaction = $this->transaction->addMoney($data);

        return new JsonResponse(['referenceId' => $transaction], 201);
    }
}