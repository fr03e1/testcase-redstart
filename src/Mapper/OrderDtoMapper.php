<?php

namespace App\Mapper;

use App\Dto\OrderDto;
use App\Entity\Order;
use App\Mapper\Exceptions\UnexpectedTypeException;

class OrderDtoMapper extends AbstractDtoMapper
{
    public function __construct(
            private OrderItemDtoMapper $orderItemDtoMapper,
    )
    {
    }

    public function transformFromObject(object $object)
    {
        if (!$object instanceof Order) {
            throw new UnexpectedTypeException('Expected type of Order but got ' . \get_class($object));
        }

        $dto = new OrderDto();
        $dto->id = $object->getId();
        $dto->orderItems = $this->orderItemDtoMapper->transformFromObjects($object->getOrderItems());
        $dto->total =  $object->getTotal();

        return $dto;

    }

}