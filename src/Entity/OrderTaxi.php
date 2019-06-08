<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\DBAL\EnumOrderStatus;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderTaxiRepository")
 */
class OrderTaxi
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $fromAddressId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $toAddressId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $orderDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="taxi")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Taxi", inversedBy="orderTaxis")
     */
    private $taxi;

    /**
     * @ORM\Column(type="orderstatus")
     */
    private $status;

    public function __construct(Client $client, int $fromAddressId, ?int $toAddressId, ?Taxi $taxi)
    {
        $this->client = $client;
        $this->fromAddressId = $fromAddressId;
        $this->toAddressId = $toAddressId;
        $this->taxi = $taxi;
        $this->status = EnumOrderStatus::$static_values[0];
        $this->amount = 0;
        $this->setOrderDate(new \DateTime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromAddressId(): ?int
    {
        return $this->fromAddressId;
    }

    public function setFromAddressId(int $fromAddressId): self
    {
        $this->fromAddressId = $fromAddressId;

        return $this;
    }

    public function getToAddressId(): ?int
    {
        return $this->toAddressId;
    }

    public function setToAddressId(?int $toAddressId): self
    {
        $this->toAddressId = $toAddressId;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(?\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getTaxi(): ?Taxi
    {
        return $this->taxi;
    }

    public function setTaxi(?Taxi $taxi): self
    {
        $this->taxi = $taxi;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }
    public function confirm()
    {
    }
}
