<?php


namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


class District
{
    private $id;
    private $name;
    private $streets;

    public function __construct(string $name, int $id)
    {
        $this->streets = new ArrayCollection();
        $this->name = $name;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    /**
     * @return Collection|Street[]
     */
    public function getStreets(): Collection
    {
        return $this->streets;
    }

    public function addStreet(Street $street): self
    {
        if (!$this->streets->contains($street)) {
            $this->streets[] = $street;
            $street->setDistrict($this);
        }

        return $this;
    }

    public function removeStreet(Street $street): self
    {
        if ($this->streets->contains($street)) {
            $this->streets->removeElement($street);
            if ($street->getDistrict() === $this) {
                $street->setDistrict(null);
            }
        }

        return $this;
    }
}