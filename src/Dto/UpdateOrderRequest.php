<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateOrderRequest
{
    #[Assert\All(
            constraints: new Assert\Collection(
                    fields: [
                            'item_id' => [new Assert\NotBlank(), new Assert\Positive()],
                            'qty' => [new Assert\NotBlank()]
                    ]
            )
    )]
    public array $items;
}