<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\ItemRepository;
use App\Request\OrderRequest;
use App\Request\UpdateOrderRequest;
use App\Service\OrderServiceInterface;
use http\Env\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderController extends AbstractController
{


    public function __construct(
            private OrderServiceInterface $orderService,
            private  ValidatorInterface $validator,
            private SerializerInterface $serializer,
    )
    {
    }

    #[Route('/orders', methods: ['GET','HEAD'])]
    public function index(): JsonResponse
    {
        $data = $this->orderService->getAllOrders();
        $json = $this->serializer->serialize($data,'json',['groups'=>'show_order']);
        return JsonResponse::fromJsonString($json,Response::HTTP_OK);
    }

    #[Route('/orders/{id}', methods: ['GET','HEAD'])]
    public function show(int $id): JsonResponse
    {
        $data = $this->orderService->getOrder($id);

        if(!$data) {
            return new JsonResponse(data: 'Order with id ' . $id . ' not found' , status: 404);
        }

        $json = $this->serializer->serialize($data,'json',['groups'=>'show_order']);

        return JsonResponse::fromJsonString($json,Response::HTTP_OK);
    }

    #[Route('/orders', methods: 'POST')]
    public function store(
            #[MapRequestPayload] OrderRequest $orderRequest,
    ): JsonResponse
    {
        $errors = $this->validator->validate($orderRequest);

        if (count($errors)>0) {
           return new JsonResponse(data: (string) $errors);
        }

         $data = $this->serializer->deserialize( json_encode($orderRequest),Order::class,'json');
     //   $items = $this->serializer->deserialize(json_decode(),OrderItem::class,'json');
       //  $this->orderService->addOrder($data);

        return JsonResponse::fromJsonString($this->serializer->serialize($data,'json'),Response::HTTP_CREATED);
    }

    #[Route('/orders/{id}', methods: 'PATCH')]
    public function update(
                                  int $id,
            #[MapRequestPayload]  UpdateOrderRequest $orderRequest,
    ): JsonResponse
    {
        $errors = $this->validator->validate($orderRequest);

        if (count($errors)>0) {
            return new JsonResponse(data: (string) $errors);
        }

        foreach ($orderRequest->items as $item) {
            $order = $this->orderService->updatedOrder($id,$item);
        }

        $dto = $this->orderDtoMapper->transformFromObject($order);
        return  new JsonResponse(data: $dto , status: Response::HTTP_CREATED);
    }
}
