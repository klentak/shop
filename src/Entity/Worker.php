<?php

namespace App\Entity;

use App\Repository\WorkerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkerRepository::class)
 */
class Worker
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Worker")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;
    
    /**
     * @ORM\Column(type="time")
     */
    private $HourStart;

    /**
     * @ORM\Column(type="time")
     */
    private $HourEnd;

    /**
     * @ORM\Column(type="boolean")
     */
    private $MainSeller;

    /**
     * @ORM\ManyToOne(targetEntity=Day::class, inversedBy="Worker")
     * @ORM\JoinColumn(nullable=false)
     */
    private $day;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getDay(): ?\DateTimeInterface
    {
        return $this->Day;
    }

    public function getHourStart(): ?\DateTimeInterface
    {
        return $this->HourStart;
    }

    public function setHourStart(\DateTimeInterface $HourStart): self
    {
        $this->HourStart = $HourStart;

        return $this;
    }

    public function getHourEnd(): ?\DateTimeInterface
    {
        return $this->HourEnd;
    }

    public function setHourEnd(\DateTimeInterface $HourEnd): self
    {
        $this->HourEnd = $HourEnd;

        return $this;
    }

    public function getMainSeller(): ?bool
    {
        return $this->MainSeller;
    }

    public function setMainSeller(bool $MainSeller): self
    {
        $this->MainSeller = $MainSeller;

        return $this;
    }

    public function setDay(?Day $day): self
    {
        $this->day = $day;

        return $this;
    }
}
