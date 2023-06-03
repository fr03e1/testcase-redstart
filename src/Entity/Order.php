<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isPaid = false;

    #[ORM\OneToMany(
            mappedBy: 'order',
            targetEntity: OrderItem::class,
            cascade: ['persist','remove'],
            fetch: 'EAGER',
            orphanRemoval: true
    )]
    private Collection $orderItems;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addItem(OrderItem $item): self
    {
        foreach ($this->getOrderItems() as $existingItem) {

            if ($existingItem->equals($item)) {
                $existingItem->setQty(
                        $existingItem->getQty() + $item->getQty()
                );

                return $this;
            }
        }

        $this->orderItems[] = $item;
        $item->setOrder($this);

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {

            if ($orderItem->getOrder() === $this) {
                $orderItem->setOrder(null);
            }
        }

        return $this;
    }

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getOrderItems() as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }
}
