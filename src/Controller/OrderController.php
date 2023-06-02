<?php

namespace App\Controller;

use App\Dto\ItemDto;
use Symfony\Component\HttpFoundation\Response;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderController extends AbstractController
{
    public function __construct(
            private OrderService $orderService,
            private  ValidatorInterface $validator,
    )
    {
    }

    #[Route('/orders', name: 'order.index', methods: ['GET','HEAD'])]
    public function index(): JsonResponse
    {
        $data = $this->orderService->getAllOrders();
        return new JsonResponse(data: $data , status: Response::HTTP_OK);
    }

    #[Route('/orders/{id}', name: 'order.show', methods: ['GET','HEAD'])]
    public function show(int $id): JsonResponse
    {
        return $this->json($this->orderService->getOrder($id));
    }

    #[Route('/orders', name: 'order.store', methods: 'POST')]
    public function store(
            #[MapRequestPayload]  ItemDto $itemDto,
    ): JsonResponse
    {
        $errors = $this->validator->validate($itemDto);

        if (count($errors)>0) {
           return$this->json((string) $errors);
        }

        return $this->json(data: $itemDto);
    }

    #[Route('/order/{id}', name: 'order.update',methods: 'PATCH')]
    public function update(): JsonResponse
    {
        return $this->json([
                'message' => 'Welcome to your new controller!',
                'path' => 'src/Controller/OrderController.php',
        ]);
    }

    #[Route('/order/{id}', name: 'order.delete',methods: 'DELETE')]
    public function delete(): JsonResponse
    {
        return $this->json([
                'message' => 'Welcome to your new controller!',
                'path' => 'src/Controller/OrderController.php',
        ]);
    }
}
