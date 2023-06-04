<?php

declare(strict_types=1);

namespace App\Mapper;

interface DtoMapperInterface
{
    public function transformFromObject(object $object);
    public function transformFromObjects(iterable $objects): iterable;
}