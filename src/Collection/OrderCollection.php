<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
