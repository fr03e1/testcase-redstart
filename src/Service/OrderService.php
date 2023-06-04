<?php

namespace App\Service;

use App\Dto\OrderRequest;
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

class OrderService implements OrderServiceInterface
{
    public function __construct(
            private OrderRepository $orderRepository,
            private ItemRepository $itemRepository,
            private EntityManagerInterface $entityManager,
    )
    {
    }

    public function getOrder(int $orderId): Order
    {
        $order = $this->orderRepository->findOneBy(['id' => $orderId]);

        if(!$order) {
            throw new EntityNotFoundException('Order with id ' . $orderId . ' not exist');
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

        foreach ($items as $item) {
            $i = $this->itemRepository->find($item['item_id']);
            $orderItem = new OrderItem();

            $orderItem->setItem($i)
                ->setQty($item['qty'])
                ->setPrice($i->getPrice() * $orderItem->getQty());

            $order->addItem($orderItem);
        }

        $this->orderRepository->save($order,true);
        return $order;
    }

    public function updatedOrder(int $id, array $items): ?Order
    {
        $order = $this->orderRepository->findOneBy(['id' => $id]);

        $this->entityManager->beginTransaction();

        try{
            $order->removeOrderItem($order->getOrderItems()->first());
            $this->orderRepository->save($order,true);
            $this->entityManager->getConnection()->commit();
        }catch (\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }
        return $order;
    }
}