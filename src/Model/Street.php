<?php


namespace App\Model;


class Street
{
    private $id;
    private $name;
    private $district;

    /**
     * Street constructor.
     * @param string $name
     * @param District|null $district
     * @param int|null $id
     */
    public function __construct(string $name, ?District $district, ?int $id)
    {
        $this->district =$district;
        $this->name = $name;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name): void
    {
        $this->name = $name;
    }


    public function getDistrict(): ?District
    {
        return $this->district;
    }


    public function setDistrict(?District $district): void
    {
        $this->district = $district;
    }

}