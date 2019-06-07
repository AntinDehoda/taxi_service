<?php


namespace App\Collection;


use App\Model\OrderTaxi;

class OrderCollection implements \IteratorAggregate
{
    private $orders;

    public function __construct(OrderTaxi ...$orders)
    {
        $this->orders = $orders;
    }

    public function addOrder(OrderTaxi $order): void
    {
        $this->orders[] = $order;
    }

    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->allTaxi);
    }

}