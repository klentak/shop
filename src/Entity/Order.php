<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
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
    private $Date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Transport;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="Orders")
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getTransport(): ?bool
    {
        return $this->Transport;
    }

    public function setTransport(bool $Transport): self
    {
        $this->Transport = $Transport;

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
