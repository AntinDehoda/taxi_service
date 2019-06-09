<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Taxi
{
    private $id;
    private $firstName;
    private $lastName;
    private $phone;
    private $district;
    private $car;
    private $orderTaxis;

    public function __construct(string $phone, string $firstName, ?int $id)
    {
        $this->id = $id;
        $this->phone = $phone;
        $this->firstName = $firstName;
        $this->lastName = '';
        $this->car = '';
        $this->orderTaxis = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getDistrict()
    {
        return $this->district;
    }

    public function setDistrict($district): void
    {
        $this->district = $district;
    }

    public function getCar(): string
    {
        return $this->car;
    }

    public function setCar(string $car): void
    {
        $this->car = $car;
    }
    public function __toString()
    {
        return 'Driver: ' . $this->getFirstName() . ', phone: ' . $this->getPhone();
    }
}
