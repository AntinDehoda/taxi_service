<?php


namespace App\Model;


use Doctrine\Common\Collections\ArrayCollection;

class Taxi
{
    private $id;
    private $firstName;
    private $lastName;
    private $phone;
    private $districtId;
    private $car;
    private $orderTaxis;

    public function __construct(string $phone, string $firstName, ?int $id )
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

    public function getDistrictId()
    {
        return $this->districtId;
    }

    public function setDistrictId($districtId): void
    {
        $this->districtId = $districtId;
    }

    public function getCar(): string
    {
        return $this->car;
    }

    public function setCar(string $car): void
    {
        $this->car = $car;
    }

}