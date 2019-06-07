<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * @ORM\Column(type="integer")
     */
    private $streetId;

    /**
     * @ORM\Column(type="integer")
     */
    private $house;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $apartment;

    public function __construct(int $streetId, string $house)
    {
        $this->streetId = $streetId;
        $this->house = $house;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreetId(): ?int
    {
        return $this->streetId;
    }

    public function setStreetId(int $streetId): self
    {
        $this->streetId = $streetId;

        return $this;
    }

    public function getHouse(): ?int
    {
        return $this->house;
    }

    public function setHouse(int $house): self
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
}
