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
 * @ORM\Entity(repositoryClass="App\Repository\DistrictRepository")
 */
class District
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Street", mappedBy="district", cascade={"persist", "remove"})
     */
    private $streets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Taxi", mappedBy="district", cascade={"persist", "remove"})
     */
    private $taxis;

    public function __construct(string $name, int $id)
    {
        $this->streets = new ArrayCollection();
        $this->taxis = new ArrayCollection();
        $this->name = $name;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
            // set the owning side to null (unless already changed)
            if ($street->getDistrict() === $this) {
                $street->setDistrict(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Taxi[]
     */
    public function getTaxis(): Collection
    {
        return $this->taxis;
    }

    public function addTaxi(Taxi $taxi): self
    {
        if (!$this->taxis->contains($taxi)) {
            $this->taxis[] = $taxi;
            $taxi->setDistrict($this);
        }

        return $this;
    }

    public function removeTaxi(Taxi $taxi): self
    {
        if ($this->taxis->contains($taxi)) {
            $this->taxis->removeElement($taxi);
            // set the owning side to null (unless already changed)
            if ($taxi->getDistrict() === $this) {
                $taxi->setDistrict(null);
            }
        }

        return $this;
    }
}
