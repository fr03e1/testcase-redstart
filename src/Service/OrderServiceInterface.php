<?php

namespace App\Service;

use App\Entity\Order;

interface OrderServiceInterface
{
    public function getOrder(int $orderId): ?Order;

    public function getAllOrders(): ?array;

    public function addOrder(array $items): ?Order;

    public function updatedOrder(int $id, array $items): ?Order;
}