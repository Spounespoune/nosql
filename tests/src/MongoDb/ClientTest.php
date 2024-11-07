<?php

namespace App\Tests\src\MongoDb;

use App\MongoDb\Service\MongoDbService;
use MongoDB\Collection;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private readonly MongoDbService $mongoDbService;

    public function setUp(): void
    {
        $this->mongoDbService = $this->createMock(MongoDbService::class);
    }

    public function testGetCollection()
    {
        $collectionMock = $this->createMock(Collection::class);
        $this->mongoDbService->method('getCollection')->willReturn($collectionMock);
        $collection = $this->mongoDbService->getCollection('test');

        $this->assertInstanceOf(Collection::class, $collection);
    }
}