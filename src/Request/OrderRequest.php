<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class OrderRequest
{
    #[Assert\All(
           constraints: new Assert\Collection(
                   fields: [
                      "price" => [new Assert\NotBlank(),new Assert\GreaterThanOrEqual(1)],
                      "qty" => [new Assert\NotBlank(),new Assert\GreaterThanOrEqual(1)],
                       'item' => [new Assert\Collection(
                               fields: [
                                       "name" => [
                                               new Assert\NotBlank(),
                                               new Assert\Length(min: 3,max: 255, minMessage: 'min_length',maxMessage: 'max_length')
                                       ],
                                        "price" => [
                                                new Assert\NotBlank(),
                                                new Assert\GreaterThanOrEqual(1)
                                        ]
                               ]
                       )]
                    ]
            )
    )]
    public array $orderItems;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3,max:255, minMessage: 'min_length',maxMessage: 'max_length')]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8,max: 11, minMessage: 'min_length',maxMessage: 'max_length')]
   #[Assert\Regex(pattern: "/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/", message: "number_only")]
    public string $phone;

    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(1, message: "min_equals")]
    public int $total;
}