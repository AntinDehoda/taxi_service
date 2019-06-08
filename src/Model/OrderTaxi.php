<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

class OrderTaxi
{
    private $id;
    private $client;
    private $fromAddressId;
    private $toAddressId;
    private $taxi;
    private $orderDate;
    private $amount;
    private $status;

    public function __construct(Client $client, int $fromAddressId, ?int $toAddressId, ?Taxi $taxi, ?int $id)
    {
        $this->client = $client;
        $this->fromAddressId = $fromAddressId;
        $this->toAddressId = $toAddressId;
        $this->taxi = $taxi;
        $this->id = $id;
        $this->setOrderDate(new \DateTime('now'));
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getClient(): Client
    {
        return $this->client;
    }


    public function setClient($client): void
    {
        $this->client = $client;
    }


    public function getFromAddressId()
    {
        return $this->fromAddressId;
    }


    public function setFromAddressId($fromAddressId): void
    {
        $this->fromAddressId = $fromAddressId;
    }


    public function getToAddressId()
    {
        return $this->toAddressId;
    }


    public function setToAddressId($toAddressId): void
    {
        $this->toAddressId = $toAddressId;
    }


    public function getTaxi(): ?Taxi
    {
        return $this->taxi;
    }


    public function setTaxi($taxi): void
    {
        $this->taxi = $taxi;
    }

    public function getOrderDate(): ?\DateTime
    {
        return $this->orderDate;
    }

    public function setOrderDate($orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }
}
