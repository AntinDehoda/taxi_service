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
 * @ORM\Entity(repositoryClass="App\Repository\TaxiRepository")
 */
class Taxi
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
    private $car;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\District", inversedBy="taxis", cascade={"persist", "remove"})
     */
    private $district;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderTaxi", mappedBy="taxi", cascade={"persist", "remove"})
     */
    private $orderTaxis;

    public function __construct(string $phone, string $firstName, int $id)
    {
        $this->id = $id;
        $this->phone = $phone;
        $this->firstName = $firstName;
        $this->lastName = '';
        $this->car = '';
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

    public function getCar(): ?string
    {
        return $this->car;
    }

    public function setCar(?string $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

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
            $orderTaxi->setTaxi($this);
        }

        return $this;
    }

    public function removeOrderTaxi(OrderTaxi $orderTaxi): self
    {
        if ($this->orderTaxis->contains($orderTaxi)) {
            $this->orderTaxis->removeElement($orderTaxi);
            // set the owning side to null (unless already changed)
            if ($orderTaxi->getTaxi() === $this) {
                $orderTaxi->setTaxi(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return 'TaxiDriver: ' . $this->getFirstName() . ', phone: ' . $this->getPhone();
    }
}
