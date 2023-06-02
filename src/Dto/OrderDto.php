<?php

namespace App\Dto;

class OrderDto
{
    private ?int $orderId;
    private ?OrderItemDto $orderItemDto;

    /**
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    /**
     * @param int|null $orderId
     */
    public function setOrderId(?int $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return OrderItemDto|null
     */
    public function getOrderItemDto(): ?OrderItemDto
    {
        return $this->orderItemDto;
    }

    /**
     * @param OrderItemDto|null $orderItemDto
     */
    public function setOrderItemDto(?OrderItemDto $orderItemDto): void
    {
        $this->orderItemDto = $orderItemDto;
    }

}