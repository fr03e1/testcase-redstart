<?php

namespace App\Service;

use App\Entity\Order;

interface OrderServiceInterface
{
    public function getOrder(int $orderId): ?Order;

    public function getAllOrders(): ?array;

    public function addOrder(Order $order): ?Order;

    public function updatedOrder(Order $order): ?Order;

    public function deleteOrder(int $id): ?string;

    public function checkPayment(int $id, int $payment): ?string;
}