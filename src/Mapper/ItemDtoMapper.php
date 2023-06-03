<?php

namespace App\Mapper;

use App\Dto\ItemDto;
use App\Entity\Item;
use App\Mapper\Exceptions\UnexpectedTypeException;

class ItemDtoMapper extends AbstractDtoMapper
{

    public function transformFromObject(object $object)
    {
        if (!$object instanceof Item) {
            throw new UnexpectedTypeException('Expected type of Item but got ' . \get_class($object));
        }

        $dto = new ItemDto();
        $dto->name = $object->getName();
        $dto->price = $object->getPrice();

        return $dto;
    }
}