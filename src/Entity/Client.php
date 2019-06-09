<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", cascade={"persist", "remove"})
     */
    private $homeAddress;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderTaxi", mappedBy="client", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $orderTaxis;

    public function __construct(string $phone, string $firstName, ?string $lastName, ?int $id)
    {
        $this->phone = $phone;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->id = $id;
        $this->orderTaxis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getHomeAddress(): ?Address
    {
        return $this->homeAddress;
    }

    public function setHomeAddress(?Address $homeAddress): self
    {
        $this->homeAddress = $homeAddress;

        return $this;
    }

    /**
     * @return Collection|OrderTaxi[]
     */
    public function getOrderTaxis(): Collection
    {
        return $this->orderTaxis;
    }

    public function addOrderTaxi(OrderTaxi $orderTaxi): self
    {
        if (!$this->orderTaxis->contains($orderTaxi)) {
            $this->orderTaxis[] = $orderTaxi;
            $orderTaxi->setClient($this);
        }

        return $this;
    }

    public function removeOrderTaxi(OrderTaxi $orderTaxi): self
    {
        if ($this->orderTaxis->contains($orderTaxi)) {
            $this->orderTaxis->removeElement($orderTaxi);
            // set the owning side to null (unless already changed)
            if ($orderTaxi->getClient() === $this) {
                $orderTaxi->setClient(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return 'Client: ' . $this->getFirstName() . ', phone: ' . $this->getPhone();
    }
}
