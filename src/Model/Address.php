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
    private $streetId;
    private $house;
    private $apartment;

    public function __construct(int $streetId, string $house)
    {
        $this->streetId = $streetId;
        $this->house = $house;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getStreet(): int
    {
        return $this->streetId;
    }


    public function setStreet($streetId): void
    {
        $this->streetId = $streetId;
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
}
