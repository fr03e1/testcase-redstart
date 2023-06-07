<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateOrderRequest
{
    public array $orderItems;
    public string $name;
    public string $phone;
}