<?php

namespace App\MongoDb\Validation;

readonly class TaskValidationSchema implements ValidationSchemaInterface
{
    public static function getSchema(): array
    {
        return [
            '$jsonSchema' => [
                'bsonType' => 'object',
                'title' => 'Task',
                'required' => ['article', 'description'],
                'properties' => [
                    'article' => ArticleValidationSchema::getSchema()['$jsonSchema'],
                    'description' => [
                        'bsonType' => 'string',
                        'description' => 'The description of the task',
                    ]
                ],
            ]
        ];
    }
}