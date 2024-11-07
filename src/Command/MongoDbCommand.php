<?php

declare(strict_types=1);

namespace App\Command;

use App\MongoDb\Service\MongoDbService;
use App\Repository\TaskRepository;
use MongoDB\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(name: 'app:mongo_db', description: 'Connection test')]
class MongoDbCommand extends Command
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        parent::__construct();
        $this->taskRepository = $taskRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $task = $this->taskRepository->findAll();
        dump($task);
        //$collection = $database->selectCollection('article');
        //$collection->insertOne(['test1' => 'value']);

        //$article = $collection->find(['test1' => 'value']);
        //$article = $collection->findOne(['test1' => 'value']);
        //dump($article);
        //dump($article['_id']);
        //dump($article->toArray());
        //$io->info($article->toArray());

        $output->writeln('Database and collection created successfully.');

        return Command::SUCCESS;
    }
}
