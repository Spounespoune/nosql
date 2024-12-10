<?php

namespace App\Controller\ElasticController;

use Elastic\Elasticsearch\ClientBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MoviesController extends AbstractController
{
    #[Route('/movies/{id}', name: 'movies', methods: ['PUT'])]
    public function edit(Request $request, string $id): JsonResponse
    {
        $data = $request->toArray();
        $client = ClientBuilder::create()
            ->setHosts(['http://elasticsearch:9200'])
            ->setBasicAuthentication('elastic', 'test')
            ->build();

        $client->update([
            'index' => 'movies',
            'id' => $id,
            'body' => [
                'doc' => $data
            ]
        ]);

        try {
            return $this->json(['success'],);
        } catch (\Exception $exception) {
            dump($exception->getMessage());
            return $this->json(['error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}