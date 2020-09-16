<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Address;

    /**
     * @ORM\OneToMany(targetEntity=Day::class, mappedBy="Location")
     */
    private $Days;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Open;

    public function __construct()
    {
        $this->Days = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    /**
     * @return Collection|Day[]
     */
    public function getDays(): Collection
    {
        return $this->Days;
    }

    public function addDay(Day $day): self
    {
        if (!$this->Days->contains($day)) {
            $this->Days[] = $day;
            $day->setLocation($this);
        }

        return $this;
    }

    public function removeDay(Day $day): self
    {
        if ($this->Days->contains($day)) {
            $this->Days->removeElement($day);
            // set the owning side to null (unless already changed)
            if ($day->getLocation() === $this) {
                $day->setLocation(null);
            }
        }

        return $this;
    }

    public function getOpen(): ?bool
    {
        return $this->Open;
    }

    public function setOpen(bool $Open): self
    {
        $this->Open = $Open;

        return $this;
    }
}
