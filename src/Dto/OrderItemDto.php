<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class OrderItemDto
{
    public string $item;
    public int $qty;
    public float $total;
}