<?php

namespace App\Command\MongoDb;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'mongodb:collection:update', description: '', aliases: ['m:c:u'])]
class CollectionUpdateCommand extends AbstractCollectionCommand
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //TODO
    }
}