<?php

namespace App\MongoDb\Validation;

class ArticleValidationSchema implements ValidationSchemaInterface
{

    public static function getSchema(): array
    {
        return [
            '$jsonSchema' => [
                'bsonType' => 'object',
                'title' => 'Article',
                'description' => 'Article',
                'required' => ['title', 'description', 'date'],
                'properties' => [
                    'title' => [
                        'bsonType' => 'string',
                        'description' => 'Title of article',
                    ],
                    'description' => [
                        'bsonType' => 'string',
                        'description' => 'Description of article',
                    ],
                    'date' => [
                        'bsonType' => 'date',
                        'description' => 'Date of article',
                    ]
                ],
            ]
        ];
    }
}