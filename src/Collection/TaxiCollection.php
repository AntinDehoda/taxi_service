<?php


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