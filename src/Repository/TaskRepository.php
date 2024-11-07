<?php

namespace App\Repository;

use App\MongoDb\Service\MongoDbService;
use MongoDB\BSON\ObjectId;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

class TaskRepository extends AbstractRepository
{
    private const TABLE_NAME = 'task';
    private readonly Collection $collection;

    public function __construct(MongoDbService $mongoDbService)
    {
        parent::__construct($mongoDbService);
        $this->collection = $this->mongoDbService
            ->getCollection(self::TABLE_NAME);
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