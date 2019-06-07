<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $homeAddressId;

    /**
     * @ORM\Column(type="integer")
     */
    private $currentOrderId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderTaxi", mappedBy="client", cascade={"persist", "remove"})
     */
    private $taxi;
    public function __construct(string $phone, string $firstName, ?string $lastName, ?int $id)
    {
        $this->phone = $phone;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->id = $id;
        $this->taxi = new ArrayCollection();
        $this->currentOrderId = 0;
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

    public function getHomeAddressId(): ?int
    {
        return $this->homeAddressId;
    }

    public function setHomeAddressId(?int $homeAddressId): self
    {
        $this->homeAddressId = $homeAddressId;

        return $this;
    }

    public function getCurrentOrderId(): ?int
    {
        return $this->currentOrderId;
    }

    public function setCurrentOrderId(int $currentOrderId): self
    {
        $this->currentOrderId = $currentOrderId;

        return $this;
    }

    /**
     * @return Collection|OrderTaxi[]
     */
    public function getTaxi(): Collection
    {
        return $this->taxi;
    }

    public function addTaxi(OrderTaxi $taxi): self
    {
        if (!$this->taxi->contains($taxi)) {
            $this->taxi[] = $taxi;
            $taxi->setClient($this);
        }

        return $this;
    }

    public function removeTaxi(OrderTaxi $taxi): self
    {
        if ($this->taxi->contains($taxi)) {
            $this->taxi->removeElement($taxi);
            // set the owning side to null (unless already changed)
            if ($taxi->getClient() === $this) {
                $taxi->setClient(null);
            }
        }

        return $this;
    }
    public function toString()
    {
        return 'Client: ' . $this->getFirstName() . ', phone: ' . $this->getPhone();
    }
}
