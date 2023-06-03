<?php

namespace App\Service;

use App\Dto\OrderRequest;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\ItemRepository;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityNotFoundException;

class OrderService
{
    public function __construct(
            private OrderRepository $orderRepository,
            private ItemRepository $itemRepository,
    )
    {
    }

    public function getOrder(int $orderId): Order
    {
        $order = $this->orderRepository->find($orderId);
        if(!$order) {
            throw new EntityNotFoundException('Order with id ' . $orderId . ' not exist');
        }

        return $order;
    }

    public function getAllOrders(): ?array
    {
        return $this->orderRepository->findAll();
    }

    public function addOrder(array $items): Order
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

    public function updatedOrder(int $id): Order
    {
        $order = $this->orderRepository->find($id);
        return $order;
    }
}