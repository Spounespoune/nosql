<?php

namespace App\Repository;

use App\MongoDb\Service\MongoDbService;

class AbstractRepository
{
    public function __construct(public readonly MongoDbService $mongoDbService)
    {
    }
}