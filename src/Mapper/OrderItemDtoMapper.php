<?php

namespace App\Mapper;

use App\Dto\OrderItemDto;
use App\Entity\OrderItem;
use App\Mapper\Exceptions\UnexpectedTypeException;

class OrderItemDtoMapper extends AbstractDtoMapper
{
    public function __construct(
            private ItemDtoMapper $itemDtoMapper,
    )
    {
    }

    public function transformFromObject(object $object)
    {
        if (!$object instanceof OrderItem) {
            throw new UnexpectedTypeException('Expected type of OrderItem but got ' . \get_class($object));
        }

        $dto = new OrderItemDto();
        $dto->total = $object->getPrice();
        $dto->qty = $object->getQty();
        $dto->item = $object->getItem()->getName();

        return $dto;

    }

}