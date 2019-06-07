<?php


namespace App\Model;


class Client
{
    private $id;
    private $firstName;
    private $lastName;
    private $phone;
    private $email;
    private $homeAddressId;
    private $lastDate;
    private $currentOrderId;

    /**
     * Client constructor.
     * @param string $phone
     * @param string|null $firstName
     * @param string|null $lastName
     * @param int|null $id
     */
    public function __construct(string $phone, ?string $firstName, ?string $lastName, ?int $id)
    {
        $this->phone = $phone;
        $this->firstName = $firstName ?? "ClientName";
        $this->lastName = $lastName ?? "ClientLastName";
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getHomeAddressId()
    {
        return $this->homeAddressId;
    }

    /**
     * @param mixed $homeAddressId
     */
    public function setHomeAddressId($homeAddressId): void
    {
        $this->homeAddressId = $homeAddressId;
    }

    /**
     * @return mixed
     */
    public function getLastDate()
    {
        return $this->lastDate;
    }

    /**
     * @param mixed $lastDate
     */
    public function setLastDate($lastDate): void
    {
        $this->lastDate = $lastDate;
    }

    /**
     * @return mixed
     */
    public function getCurrentOrderId()
    {
        return $this->currentOrderId;
    }

    /**
     * @param mixed $currentOrderId
     */
    public function setCurrentOrderId($currentOrderId): void
    {
        $this->currentOrderId = $currentOrderId;
    }
    public function toString()
    {
        return 'Client: ' . $this->getFirstName() . ', phone: ' . $this->getPhone();
    }

}