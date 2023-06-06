<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class OrderRequest
{

    #[Assert\All(
         constraints: new Assert\Collection(
                 fields: [
                         'price' => [new Assert\NotBlank(), new Assert\Positive()],
                          'item' => [new Assert\NotBlank()],
                          'qty' => [new Assert\NotBlank()]
                 ]
            )
    )]
    public array $orderItems;
    public string $name;
    public string $phone;
    public float $total;
}