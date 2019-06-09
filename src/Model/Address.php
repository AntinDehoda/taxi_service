<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

class Address
{
    private $id;
    private $street;
    private $house;
    private $apartment;

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


    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getStreet(): Street
    {
        return $this->street;
    }


    public function setStreet($streetId): void
    {
        $this->street = $streetId;
    }


    public function getHouse(): ?string
    {
        return $this->house;
    }


    public function setHouse($house): void
    {
        $this->house = $house;
    }


    public function getApartment(): ?int
    {
        return $this->apartment;
    }


    public function setApartment($apartment): void
    {
        $this->apartment = $apartment;
    }

    public function __toString()
    {
        return 'Address: ' . (string) $this->getStreet() . ', House: ' . $this->getHouse();
    }
}
