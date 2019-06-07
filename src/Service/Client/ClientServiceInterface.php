<?php


namespace App\Service\Client;


use App\Collection\ClientCollection;
use App\Model\Address;
use App\Model\Client;

interface ClientServiceInterface
{
    public function create(string $phone, string $firstName, ?string $lastName): Client;
    public function find(string $phone): ?Client;
}