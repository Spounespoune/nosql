<?php

namespace App\MongoDb\Service;

use MongoDB\Client;
use MongoDB\Collection;

readonly class MongoDbService
{
    public function __construct(private Client $client, private string $database)
    {
    }

    public function getCollection(string $collectionName): Collection
    {
        $database = $this->client->selectDatabase($this->database);
        return $database->selectCollection($collectionName);
    }
}