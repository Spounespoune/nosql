<?php

namespace App\MongoDb\Service;

use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Database;

readonly class MongoDbService
{
    public Database $database;

    public function __construct(private Client $client, private string $databaseName)
    {
        $this->database = $this->client->selectDatabase($this->databaseName);
    }

    public function getCollection(string $collectionName): Collection
    {
        return $this->database->selectCollection($collectionName);
    }

    public function isCollectionExists(string $collectionNameToCheck): bool
    {
        $collectionNames  = $this->database->listCollectionNames();

        foreach ($collectionNames as $collectionName) {
            if ($collectionNameToCheck === $collectionName) {
                return true;
            }
        }

        return false;
    }
}