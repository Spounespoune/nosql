<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    public function __construct(public readonly TaskRepository $taskRepository)
    {
    }

    #[Route('/task', name:'tasks', methods: ['GET'])]
    public function getTask(): JsonResponse
    {
        return new JsonResponse($this->taskRepository->findAll());
    }

    #[Route('/task/add', name:'task_add', methods: ['POST'])]
    public function addTask(Request $request): JsonResponse
    {
        $taskContent = json_decode($request->getContent());
        $this->taskRepository->getCollection()->insertOne($taskContent);
    }
}