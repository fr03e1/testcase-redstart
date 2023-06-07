<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use App\Repository\OrderItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints\Type;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(
            type: Types::DECIMAL,
            precision: 10,
            scale: 2
    )]
    #[Groups(['show_order'])]
    protected ?string $price = null;

    #[ORM\ManyToOne(cascade: ['persist'],fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['show_order'])]
    protected ?Item $item = null;

    #[ORM\ManyToOne (cascade: ['persist'],fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    protected ?Order $order = null;

    #[ORM\Column]
    #[Groups(['show_order'])]
    protected ?int $qty = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }
}
