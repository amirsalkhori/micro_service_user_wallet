<?php

namespace App\Command;

use App\Service\TransactionService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(
    name: 'app:transaction-amount',
    description: 'Create daily job to calculate total amount of transactions.',
)]
class TransactionCommand extends Command
{
    /**
     * @var TransactionService
     */
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        parent::__construct();
        $this->transactionService = $transactionService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $transactionAmount = $this->transactionService->getTotalAmountTransaction();
        $output->writeln([
            'Lets start calculating the transaction',
            '============',
        ]);
        $output->writeln('Whoa!');
        $output->writeln("Total transaction amount is: $transactionAmount");

        return Command::SUCCESS;
    }
}