<?php

namespace App\Dto;

use App\Entity\OrderItem;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

class ItemDto
{
   #[Assert\NotBlank]
   public ?string $hello;
}