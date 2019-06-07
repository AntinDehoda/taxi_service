<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Collection;

use App\Model\Taxi;

class TaxiCollection implements \IteratorAggregate
{
    private $allTaxi;

    public function __construct(Taxi ...$allTaxi)
    {
        $this->allTaxi = $allTaxi;
    }

    public function addClient(Taxi $taxi): void
    {
        $this->allTaxi[] = $taxi;
    }

    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->allTaxi);
    }
}
