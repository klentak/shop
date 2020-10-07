<?php

namespace App\Entity;

use App\Repository\LimitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LimitRepository::class)
 * @ORM\Table(name="`limit`")
 */
class Limit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $Worth;

    /**
     * @ORM\Column(type="date")
     */
    private $DateStart;

    /**
     * @ORM\Column(type="date")
     */
    private $DateEnd;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="Limits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorth(): ?string
    {
        return $this->Worth;
    }

    public function setWorth(string $Worth): self
    {
        $this->Worth = $Worth;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->DateStart;
    }

    public function setDateStart(\DateTimeInterface $DateStart): self
    {
        $this->DateStart = $DateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->DateEnd;
    }

    public function setDateEnd(\DateTimeInterface $DateEnd): self
    {
        $this->DateEnd = $DateEnd;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->Location;
    }

    public function setLocation(?Location $Location): self
    {
        $this->Location = $Location;

        return $this;
    }
}
