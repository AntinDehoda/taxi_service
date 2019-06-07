<?php


namespace App\Collection;


use App\Model\Client;

class ClientCollection implements \IteratorAggregate
{
    private $clients;

    public function __construct(Client ...$clients)
    {
        $this->clients = $clients;
    }

    public function addClient(Client $client): void
    {
        $this->clients[] = $client;
    }

    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->clients);
    }

}