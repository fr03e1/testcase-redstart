<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateOrderRequest
{
    #[Assert\All(
            constraints: new Assert\Collection(
                    fields: [
                            'orderItem_id' => [new Assert\NotBlank(), new Assert\Positive()],
                            'qty' => [new Assert\NotBlank(), new Assert\Positive()]
                    ]
            )
    )]
    public array $items;
}