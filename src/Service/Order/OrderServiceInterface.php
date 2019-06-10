<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Order;

use App\Form\DTO\OrderDto;
use App\Model\OrderTaxi as OrderModel;
use App\Entity\OrderTaxi;

interface OrderServiceInterface
{
    public function create(OrderDto $orderDto): OrderModel;
    public function update(OrderDto $orderDto, int $id): void;
    public function edit(int $id): ?OrderDto;
    public function find(int $id): ?OrderTaxi;
    public function confirm(OrderTaxi $order): void;
    public function cancel(OrderTaxi $order): string;
}
