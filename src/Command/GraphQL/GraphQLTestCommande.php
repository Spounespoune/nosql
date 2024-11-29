<?php

namespace App\Command\GraphQL;

use App\Repository\CarRepository;
use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'graphQL', description: 'Test commande')]
class GraphQLTestCommande extends Command
{
    public function __construct(private CarRepository $carRepository)
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $rootValue = $this->carRepository->findAll();
        $schema = new Schema([
            'query' => new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'cars' => [
                        'type' => Type::listOf(new ObjectType([
                            'name' => 'Car',
                            'fields' => [
                                'model' => Type::string(),
                                'brand' => Type::string(),
                                'creation_date' =>  Type::string(),
                                'description' => Type::string(),
                            ]
                        ])),
                        'resolve' => function ($rootValue, array $args){
                            return $rootValue;
                        },
                    ],
                ],
            ]),
        ]);

        $query = <<<GRAPHQL
            query {
                cars(limit: 2, offset: 1) {
                    model,
                    brand,
                    creation_date,
                    description,
                }
            }
            GRAPHQL;

        try {
            //$result = GraphQL::executeQuery($schema, $query, $rootValue);
            //$output = $result->toArray();
            $this->mutation();
            $result2 = GraphQL::executeQuery($schema, $query, $rootValue);
            $output2 = $result2->toArray();
        } catch (\Exception $e) {
            $output = [
                'errors' => [
                    [
                        'message' => $e->getMessage()
                    ]
                ]
            ];
            $output2 = [
                'errors' => [
                    [
                        'message' => $e->getMessage()
                    ]
                ]
            ];
        }

        //dump($output);
        dump($output2);

        return Command::SUCCESS;
    }

    private function mutation(): void
    {
        $rootValue = $this->carRepository->findAll();
        $carType = new ObjectType([
            'name' => 'Car',
            'fields' => [
                'model' => Type::string(),
                'brand' => Type::string(),
                'creation_date' => Type::string(),
                'description' => Type::string(),
            ]
        ]);
        $schema = new Schema([
            'query' => new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'cars' => [
                        'type' => Type::listOf($carType),
                        'resolve' => function ($rootValue, array $args){
                            return $rootValue;
                        },
                    ],
                ],
            ]),
            'mutation' => new ObjectType([
                'name' => 'Mutation',
                'fields' => [
                    'addCar' => [
                        'type' => $carType,
                        'args' => [
                            'model' => Type::nonNull(Type::string()),
                            'brand' => Type::nonNull(Type::string()),
                            'creation_date' => Type::nonNull(Type::string()),
                            'description' => Type::nonNull(Type::string()),
                        ],
                        'resolve' => function ($rootValue, $args) {
                            $newCar = [
                                'model' => $args['model'],
                                'brand' => $args['brand'],
                                'creation_date' => $args['creation_date'],
                                'description' => $args['description'],
                            ];
                            $this->carRepository->add($newCar);
                            dump($this->carRepository->findAll());
                            return $newCar;
                        },
                    ]
                ]
            ])
        ]);

        $query = <<<GRAPHQL
            query {
                cars {
                    model,
                    brand,
                    creation_date,
                    description,
                }
            }
            GRAPHQL;

        $query1 = <<<GRAPHQL
            mutation {
                addCar(
                    model: "truc",
                    brand: "truc",
                    creation_date: "2024-01-01",
                    description: "truc",
                ) {
                    model,
                    brand,
                    description,
                    creation_date
                }
            }
            GRAPHQL;

        try {
            $result1 = GraphQL::executeQuery($schema, $query, $rootValue);
            $result2 = GraphQL::executeQuery($schema, $query1, $rootValue);
            $output1 = $result1->toArray();
            $output2 = $result2->toArray();
            $result3 = GraphQL::executeQuery($schema, $query, $rootValue);
            $output3 = $result3->toArray();
        } catch (\Exception $e) {
            $output1 = [
                'errors' => [
                    [
                        'message' => $e->getMessage()
                    ]
                ]
            ];
            $output2 = [
                'errors' => [
                    [
                        'message' => $e->getMessage()
                    ]
                ]
            ];
        }

        dump($output1);
        dump($output2);
        dump($output3);
    }
};