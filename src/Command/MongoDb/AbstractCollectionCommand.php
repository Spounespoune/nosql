<?php

namespace App\Command\MongoDb;

use App\MongoDb\Service\MongoDbService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCollectionCommand extends Command
{
    public const NAMESPACE_VALIDATION_SCHEMA = 'App\MongoDb\Validation';
    public const SUFFIX_VALIDATION_SChEMA_CLASS_NAME = 'ValidationSchema';
    public MongoDbService $mongoDbService;
    public string $collectionClassName;
    public string $validationSchemaClassName = '';

    public function __construct(MongoDbService $mongoDbService)
    {
        parent::__construct();
        $this->mongoDbService = $mongoDbService;
    }

    protected function configure(): void
    {
        $this->addArgument('collectionName', InputArgument::REQUIRED, 'Collection name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->collectionClassName = $input->getArgument('collectionName');
        $this->validationSchemaClassName =
            self::NAMESPACE_VALIDATION_SCHEMA . '\\' . ucfirst($this->collectionClassName) . self::SUFFIX_VALIDATION_SChEMA_CLASS_NAME;

        if (true === class_exists($this->validationSchemaClassName)
            && false === method_exists($this->validationSchemaClassName, 'getSchema')) {
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}