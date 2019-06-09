<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
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
    private $house;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $apartment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Street", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $street;

    public function __construct(Street $street, string $house, ?int $id)
    {
        $this->street = $street;
        $this->house = $house;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHouse(): ?string
    {
        return $this->house;
    }

    public function setHouse(string $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function getApartment(): ?string
    {
        return $this->apartment;
    }

    public function setApartment(?string $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }

    public function getStreet(): ?Street
    {
        return $this->street;
    }

    public function setStreet(?Street $street): self
    {
        $this->street = $street;

        return $this;
    }
    public function __toString()
    {
        return 'Address: ' . (string) $this->getStreet() . ', House: ' . $this->getHouse();
    }
}
