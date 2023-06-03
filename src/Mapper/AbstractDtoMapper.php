<?php

declare(strict_types=1);

namespace App\Mapper;

abstract class AbstractDtoMapper implements DtoMapperInterface
{
    public function transformFromObjects(iterable $objects): iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            $dto[] = $this->transformFromObject($object);
        }

        return $dto;
    }

}