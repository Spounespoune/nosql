<?php

namespace App\MongoDb\Validation;

interface ValidationSchemaInterface
{
    public static function getSchema(): array;
}