<?php

namespace App\Repository;

use App\MongoDb\Service\MongoDbService;
use MongoDB\BSON\ObjectId;
use MongoDB\Collection;

class TaskRepository extends AbstractRepository
{
    private const COLLECTION_NAME = 'task';
    private readonly Collection $collection;

    public function __construct(MongoDbService $mongoDbService)
    {
        parent::__construct($mongoDbService);
        $this->collectionName = self::COLLECTION_NAME;
        $this->collection = $this->getCollection();
    }

    public function findAll(): array
    {
        return $this->collection
            ->find()
            ->toArray();
    }

    public function findOneById(string $id): array|null|object
    {
        $objectId = new ObjectId($id);
        return $this->collection
            ->findOne(['_id' => $objectId]);
    }
}