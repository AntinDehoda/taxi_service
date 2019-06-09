<?php

namespace App\Entity;

use App\Status\OrderStatus;
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
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fromAddress;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", cascade={"persist", "remove"})
     */
    private $toAddress;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="orderTaxis", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Taxi", inversedBy="orderTaxis", cascade={"persist", "remove"})
     */
    private $taxi;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $status;

    public function __construct(Client $client, Address $fromAddress, ?Address $toAddress, ?Taxi $taxi)
    {
        $this->client = $client;
        $this->fromAddress = $fromAddress;
        $this->toAddress = $toAddress;
        $this->taxi = $taxi;
        $this->status = OrderStatus::CREATED;
        $this->amount = 0;
        $this->setOrderDate(new \DateTime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
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

    public function getFromAddress(): ?Address
    {
        return $this->fromAddress;
    }

    public function setFromAddress(?Address $fromAddress): self
    {
        $this->fromAddress = $fromAddress;

        return $this;
    }

    public function getToAddress(): ?Address
    {
        return $this->toAddress;
    }

    public function setToAddress(?Address $toAddress): self
    {
        $this->toAddress = $toAddress;

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
