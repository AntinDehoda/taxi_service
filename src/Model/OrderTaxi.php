<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

use App\Status\OrderStatus;

class OrderTaxi
{
    private $id;
    private $client;
    private $fromAddress;
    private $toAddress;
    private $taxi;
    private $orderDate;
    private $amount;
    private $status;


    public function __construct(Client $client, Address $fromAddress, ?Address $toAddress, ?Taxi $taxi, ?int $id)
    {
        $this->client = $client;
        $this->fromAddress = $fromAddress;
        $this->toAddress = $toAddress;
        $this->taxi = $taxi;
        $this->id = $id;
        $this->amount = 0;
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


    public function getFromAddress(): Address
    {
        return $this->fromAddress;
    }


    public function setFromAddress($fromAddress): self
    {
        $this->fromAddress = $fromAddress;
        return $this;
    }


    public function getToAddress(): Address
    {
        return $this->toAddress;
    }


    public function setToAddress($toAddress): self
    {
        $this->toAddress = $toAddress;
        return $this;
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

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    public function cancel(): void
    {
        $this->status = OrderStatus::CANCELLED;
    }

    public function update(): void
    {
        $this->status = OrderStatus::UPDATED;
    }
    public function confirm(): void
    {
        $this->status = OrderStatus::EXECUTED;
    }
    public function complete(): void
    {
        $this->status = OrderStatus::COMPLETED;
    }

}
