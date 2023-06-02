<?php

namespace App\Dto;

class OrderItemDto
{
    private ?int $id;
    private ?string $price;
    private ?OrderDto $orderDto;
    private ?ItemDto $itemDto;
    private ?int $qty;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string|null $price
     */
    public function setPrice(?string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return OrderDto|null
     */
    public function getOrderDto(): ?OrderDto
    {
        return $this->orderDto;
    }

    /**
     * @param OrderDto|null $orderDto
     */
    public function setOrderDto(?OrderDto $orderDto): void
    {
        $this->orderDto = $orderDto;
    }

    /**
     * @return ItemDto|null
     */
    public function getItemDto(): ?ItemDto
    {
        return $this->itemDto;
    }

    /**
     * @param ItemDto|null $itemDto
     */
    public function setItemDto(?ItemDto $itemDto): void
    {
        $this->itemDto = $itemDto;
    }

    /**
     * @return int|null
     */
    public function getQty(): ?int
    {
        return $this->qty;
    }

    /**
     * @param int|null $qty
     */
    public function setQty(?int $qty): void
    {
        $this->qty = $qty;
    }



}