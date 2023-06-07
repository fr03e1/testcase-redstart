<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService implements OrderServiceInterface
{
    public function __construct(
            private OrderRepository $orderRepository,
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

    public function addOrder(Order $order): ?Order
    {
        $orderItems = $order->getOrderItems();
        $order->setOrderItems(array());
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        foreach ($orderItems as $orderItem) {
            $orderItem->setOrder($order);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return  $order;
    }




    public function updatedOrder(Order $order): ?Order
    {
         $this->entityManager->getConnection()->beginTransaction();
         try {
             $orderItems = $order->getOrderItems();
             $order->setOrderItems(array());
             $this->entityManager->persist($order);
             $this->entityManager->flush();

             foreach ($orderItems as $orderItem) {
                 $orderItem->setOrder($order);
             }

             $this->entityManager->persist($order);
             $this->entityManager->flush();
             $this->entityManager->commit();
         }catch (\Exception $e) {
             $this->entityManager->rollback();
             throw new \Exception('Problems with transaction',500);
         }

         return $order;
    }

    public function deleteOrder(int $id): ?string
    {
        $order = $this->orderRepository->findOneBy(['id' => $id]);

        if(!$order) {
            return null;
        }

        $this->orderRepository->remove($order,true);

        return 'success';
    }

    public function checkPayment(int $id, int $payment): ?string
    {
        $order = $this->orderRepository->find($id);

        if(!$order) {
            return null;
        }

        if($order->getTotal() === $payment) {
            $order->setIsPaid(true);
            $this->orderRepository->save($order,true);
            return 'success';
        }

        return 'Error';
    }
}