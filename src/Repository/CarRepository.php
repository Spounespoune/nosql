<?php

namespace App\Repository;

class CarRepository
{
    private array $cars =  [

        [
            'model' => 'Model S',
            'brand' => 'Tesla',
            'creation_date' => '2012-06-22',
            'description' => 'Une berline électrique haut de gamme offrant une grande autonomie et des performances impressionnantes.'
        ],
        [
            'model' => 'Mustang',
            'brand' => 'Ford',
            'creation_date' => '1964-04-17',
            'description' => 'Une voiture de sport emblématique avec un design audacieux et un moteur puissant.'
        ],
        [
            'model' => 'Civic',
            'brand' => 'Honda',
            'creation_date' => '1972-07-11',
            'description' => 'Une voiture compacte réputée pour sa fiabilité et son efficacité énergétique.'
        ],
        [
            'model' => '911 Carrera',
            'brand' => 'Porsche',
            'creation_date' => '1964-09-01',
            'description' => 'Une voiture de sport classique avec un moteur à l’arrière et des performances légendaires.'
        ],
        [
            'model' => 'Corolla',
            'brand' => 'Toyota',
            'creation_date' => '1966-10-20',
            'description' => 'Une des voitures les plus vendues au monde, appréciée pour sa fiabilité et sa simplicité.'
        ]
    ];

    public function findAll(): array
    {
        return $this->cars;
    }

    public function add(array $car): void
    {
        $this->cars[] = $car;
    }
}