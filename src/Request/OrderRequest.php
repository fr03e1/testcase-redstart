<?php

namespace App\Request;

use App\Entity\OrderItem;


class OrderRequest
{
    public array $orderItems;
    public string $name;
    public string $phone;
    public int $total;
}