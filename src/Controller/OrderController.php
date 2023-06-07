<?php

namespace App\Controller;

use App\Entity\Order;
use App\Request\OrderRequest;
use App\Request\UpdateOrderRequest;
use App\Service\OrderServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderController extends AbstractController
{


    public function __construct(
            private OrderServiceInterface $orderService,
            private ValidatorInterface $validator,
            private SerializerInterface $serializer,
    ) {
    }


    #[Route('/orders', methods: ['GET', 'HEAD'])]
    public function index(): JsonResponse
    {
        $data = $this->orderService->getAllOrders();
        $json = $this->serializer->serialize($data, 'json', ['groups' => 'show_order']);
        return JsonResponse::fromJsonString($json, Response::HTTP_OK);
    }


    #[Route('/orders/{id}', methods: ['GET', 'HEAD'])]
    public function show(int $id): JsonResponse
    {
        $data = $this->orderService->getOrder($id);

        if (!$data) {
            return new JsonResponse(data: 'Order with id ' . $id . ' not found', status: 404);
        }

        $json = $this->serializer->serialize($data, 'json', ['groups' => 'show_order']);

        return JsonResponse::fromJsonString($json, Response::HTTP_OK);
    }


    #[Route('/orders', methods: 'POST')]
    public function store(
            #[MapRequestPayload] OrderRequest $orderRequest,
    ): JsonResponse {

        $errors = $this->validator->validate($orderRequest);

        if (count($errors) > 0) {
            return new JsonResponse(data: (string)$errors);
        }

        $data = $this->serializer->deserialize(
                json_encode($orderRequest),
                Order::class, 'json',
                ['groups'=>'show_order']
        );

        $order = $this->orderService->addOrder($data);
        $json = $this->serializer->serialize($data, 'json', ['groups' => 'show_order']);
        return JsonResponse::fromJsonString($json, Response::HTTP_CREATED);
    }


    #[Route('/orders/{id}', methods: 'PATCH')]
    public function update(
            #[MapRequestPayload] UpdateOrderRequest $orderRequest,
                                 Order $order
    ): JsonResponse {

        $data = $this->serializer->deserialize(
                json_encode($orderRequest),
                Order::class,
                'json',
                ['object_to_populate' => $order]
        );

        $errors = $this->validator->validate($data);

        if (count($errors) > 0) {
            return new JsonResponse(data: (string)$errors);
        }

        $updatedOrder =  $this->orderService->updatedOrder($data);
        $json =  $this->serializer->serialize($updatedOrder, 'json', ['groups'=>'show_order']);
        return JsonResponse::fromJsonString($json, Response::HTTP_CREATED);
    }

    #[Route('/orders/{id}', methods: 'DELETE')]
    public function delete(
           int $id
    ): JsonResponse {
        $data = $this->orderService->deleteOrder($id);

        if(!$data) {
            return new JsonResponse(data: 'Order with id ' . $id . ' not found', status: 404);
        }

        return JsonResponse::fromJsonString($data, Response::HTTP_OK);
    }

    #[Route('/orders/{id}/{payment}', methods: 'GET')]
    public function checkPayment(
            int $id,
            int $payment,
    ): JsonResponse {

        $data = $this->orderService->checkPayment($id,$payment);

        if(!$data) {
            return new JsonResponse(data: 'Order with id ' . $id . ' not found', status: 404);
        }

        return JsonResponse::fromJsonString($data, Response::HTTP_OK);
    }
}