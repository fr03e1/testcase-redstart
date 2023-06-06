<?php

namespace App\Service;

use App\Request\OrderRequest;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\ItemRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderService implements OrderServiceInterface
{
    public function __construct(
            private OrderRepository $orderRepository,
            private ItemRepository $itemRepository,
            private OrderItemRepository $orderItemRepository,
            private EntityManagerInterface $entityManager,
    )
    {
    }

    public function getOrder(int $orderId): ?Order
    {
        $order = $this->orderRepository->findOneBy(['id' => $orderId]);

        if(!$order) {
            return null;
        }

        return $order;
    }

    public function getAllOrders(): ?array
    {
        return $this->orderRepository->findAll();
    }

    public function addOrder(array $items): ?Order
    {
        $order = new Order();


        return $order;
    }




    public function updatedOrder(int $id,  $item): ?Order
    {
        $this->entityManager->beginTransaction();
        try{


        }catch (\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }

        return null;
    }
}