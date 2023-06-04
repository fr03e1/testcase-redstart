<?php

namespace App\Controller;

use App\Dto\OrderRequest;
use App\Dto\UpdateOrderRequest;
use App\Mapper\OrderDtoMapper;
use App\Service\OrderServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderController extends AbstractController
{


    public function __construct(
            private OrderServiceInterface $orderService,
            private  ValidatorInterface $validator,
            private OrderDtoMapper $orderDtoMapper,
    )
    {
    }

    #[Route('/orders', methods: ['GET','HEAD'])]
    public function index(): JsonResponse
    {
        $data = $this->orderService->getAllOrders();
        $dto = $this->orderDtoMapper->transformFromObjects($data);
        return new JsonResponse(data: $dto , status: Response::HTTP_OK);
    }

    #[Route('/orders/{id}', methods: ['GET','HEAD'])]
    public function show(int $id): JsonResponse
    {
        $data = $this->orderService->getOrder($id);

        if(!$data) {
            return new JsonResponse(data: 'Order with id ' . $id . ' not found' , status: 404);
        }

        $dto = $this->orderDtoMapper->transformFromObject($data);
        return new JsonResponse(data: $dto , status: Response::HTTP_OK);
    }

    #[Route('/orders', methods: 'POST')]
    public function store(
            #[MapRequestPayload]  OrderRequest $orderRequest,
    ): JsonResponse
    {
        $errors = $this->validator->validate($orderRequest);

        if (count($errors)>0) {
           return new JsonResponse(data: (string) $errors);
        }

        $order = $this->orderService->addOrder($orderRequest->items);

        $dto = $this->orderDtoMapper->transformFromObject($order);
        return  new JsonResponse(data: $dto , status: Response::HTTP_CREATED);
    }

    #[Route('/orders/{id}',methods: 'PATCH')]
    public function update(
            int $id,
            #[MapRequestPayload]  UpdateOrderRequest $orderRequest,
    ): JsonResponse
    {
        $errors = $this->validator->validate($orderRequest);

        if (count($errors) > 0) {
            return  new JsonResponse(data: (string) $errors);
        }

        $order = $this->orderService->updatedOrder($id, $orderRequest->items);
        $dto = $this->orderDtoMapper->transformFromObject($order);

        return  new JsonResponse(data: $dto, status: Response::HTTP_OK);
    }

    #[Route('/order/{id}',methods: 'DELETE')]
    public function delete(): JsonResponse
    {
        return $this->json([
                'message' => 'Welcome to your new controller!',
                'path' => 'src/Controller/OrderController.php',
        ]);
    }
}
