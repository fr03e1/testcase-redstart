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
            cascade: ['persist'],
            fetch: 'EAGER',
            orphanRemoval: true
    )]
    #[Groups(['show_order'])]
    private Collection $orderItems;

    #[ORM\Column(length: 255)]
    #[Groups(['show_order'])]
    protected ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['show_order'])]
    protected ?string $phone = null;

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

                $existingItem->setPrice(
                        $existingItem->getQty() * $item->getPrice()
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
