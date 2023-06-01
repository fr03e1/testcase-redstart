<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    #[Route('/order', name: 'order.index')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/OrderController.php',
        ]);
    }

    #[Route('/order', name: 'order.store',methods: 'POST')]
    public function store(): JsonResponse
    {
        return $this->json([
                'message' => 'Welcome to your new controller!',
                'path' => 'src/Controller/OrderController.php',
        ]);
    }

    #[Route('/order/{order}', name: 'order.update',methods: 'PATCH')]
    public function update(): JsonResponse
    {
        return $this->json([
                'message' => 'Welcome to your new controller!',
                'path' => 'src/Controller/OrderController.php',
        ]);
    }

    #[Route('/order/{order}', name: 'order.delete',methods: 'DELETE')]
    public function delete(): JsonResponse
    {
        return $this->json([
                'message' => 'Welcome to your new controller!',
                'path' => 'src/Controller/OrderController.php',
        ]);
    }
}
