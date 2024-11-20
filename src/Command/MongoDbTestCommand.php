<?php

declare(strict_types=1);

namespace App\Command;

use App\MongoDb\Service\MongoDbService;
use App\Repository\TaskRepository;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Client;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Driver\Exception\Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:mongo_db', description: 'Connection test')]
class MongoDbTestCommand extends Command
{
    private TaskRepository $taskRepository;
    private MongoDbService $mongoDbService;
    private Client $client;

    public function __construct(TaskRepository $taskRepository, MongoDbService $mongoDbService, Client $client)
    {
        parent::__construct();
        $this->taskRepository = $taskRepository;
        $this->mongoDbService = $mongoDbService;
        $this->client = $client;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Old version
        //$collection = $this->mongoDbService->getCollection('article');
        //$article = $collection->findOne(['_id' => (new ObjectId('672b47e39cfea533f3007432'))]);
        //$json = $article->jsonSerialize();
        //dump($json);
        //dd($article->toArray()[0]->storage());

        // Test
        //dump($this->client->selectDatabase('nosql')->selectCollection('article'));
        //dd($this->client->selectDatabase('nosql')->selectCollection('eriuherger'));

        // New version
        //$task = $this->taskRepository->findOneById('673308be913dc404e1031742');
        //$task['article'] = $article;
        //$result = $collection->updateOne(['_id' => (new ObjectId('6733182f29de3a703f038292'))], ['$set' => ['description' => 'toto']]);
        //$result = $this->taskRepository->updateOne(['_id' => (new ObjectId('6733182f29de3a703f038292'))], ['$set' => ['article' => $json]]);
        //dump($result->getModifiedCount());
        //dump($result->getUpsertedId());
        //$collection->insertOne(['article' => $json, 'description' => 'test1']);
        //$task = $this->taskRepository->findAll();
        //dump($task);
        //$array = $task->->offsetGet('article');

        //dump($array);

        //$article = $collection->find(['test1' => 'value']);
        //$article = $collection->findOne(['test1' => 'value']);
        //dump($article);
        //dump($article['_id']);
        //dump($article->toArray());
        //$io->info($article->toArray());

        $article = [
            'title' => 'je suis un article',
            'description' => 'je suis la description de l\'article',
            'date' => new UTCDateTime()
        ];

        $task = [
            'article' => $article,
            'description' => 'je suis la description de la tâche',
        ];

        try {
            //$this->mongoDbService->getCollection('task')->insertOne($task);
            $tasks = $this->taskRepository->findAll();

            foreach ($tasks as $task) {
                $io->note('tilte : ' . $task['article']['title']);
            }

        } catch (BulkWriteException $e) {
            // Affiche les détails de l'erreur
            echo "Error: " . $e->getMessage() . "\n";

            // Obtenir des détails supplémentaires
            $writeResult = $e->getWriteResult();
            foreach ($writeResult->getWriteErrors() as $error) {
                echo "Index: " . $error->getIndex() . "\n";
                echo "Code: " . $error->getCode() . "\n";
                echo "Message: " . $error->getMessage() . "\n";
            }
        }

        $output->writeln('successfully.');

        return Command::SUCCESS;
    }
}
