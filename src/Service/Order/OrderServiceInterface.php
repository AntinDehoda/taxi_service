<?php


namespace App\Service\Order;


use App\Form\DTO\OrderDto;
use App\Model\OrderTaxi;

interface OrderServiceInterface
{
    public function createOrder(OrderDto $orderDto): OrderTaxi;
    public function edit(int $id): ?OrderDto;
    public function find(int $id): ?OrderTaxi;
    public function confirm(int $id): void;
    public function cancel(int $id): string;
    public function update(OrderDto $orderDto, int $id): void;
}