<?php

namespace App\Command\MongoDb;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'mongodb:collection:create', description: '', aliases: ['m:c:c'])]
class CollectionCreateCommand extends AbstractCollectionCommand
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        parent::execute($input, $output);
        $io = new SymfonyStyle($input, $output);

        if (true === $this->mongoDbService->isCollectionExists($this->collectionClassName)) {
            $io->info('Collection already exists. User command mongodb:collection:update or m:c:u');

            return Command::FAILURE;
        }

        $this->mongoDbService->database->createCollection($this->collectionClassName, [
            'validator' => call_user_func([$this->validationSchemaClassName, 'getSchema']),
            'validatorLevel' => 'strict',
        ]);

        $io->success('Collection created successfully.');
        return Command::SUCCESS;
    }
}