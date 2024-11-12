<?php

namespace App\Repository;

use App\MongoDb\Service\MongoDbService;
use MongoDB\Collection;

abstract class AbstractRepository
{
    protected ?string $collectionName = null;
    public function __construct(public readonly MongoDbService $mongoDbService)
    {
    }

    public function getCollection(): Collection
    {
        if ($this->collectionName === null) {
            throw new \RuntimeException('Collection name is null');
        }

        return $this->mongoDbService->getCollection($this->collectionName);
    }

    public function updateOne(array $filter, array $update, array $options = []): array|null|object
    {
        try {
            $collection = self::getCollection()->updateOne($filter, $update, $options);
        } catch (\Throwable $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        return $collection;
    }
}