<?php

namespace App\Dto;

class OrderDto
{
    public int $id;
    public iterable $orderItems;
    public float $total;
}