<?php

namespace App\Entity;

use App\Repository\DayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DayRepository::class)
 */
class Day
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="Days")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Location;

    /**
     * @ORM\Column(type="date")
     */
    private $Date;

    /**
     * @ORM\OneToMany(targetEntity=Expenses::class, mappedBy="Day")
     */
    private $Expenses;

    /**
     * @ORM\OneToMany(targetEntity=Sold::class, mappedBy="Day")
     */
    private $Sold;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Open;

    /**
     * @ORM\OneToMany(targetEntity=Worker::class, mappedBy="day")
     */
    private $Worker;

    public function __construct()
    {
        $this->Workers = new ArrayCollection();
        $this->Expenses = new ArrayCollection();
        $this->Sold = new ArrayCollection();
        $this->Date = new \DateTime();
        $this->Worker = new ArrayCollection();
        $this->User = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->Location;
    }

    public function setLocation(?Location $Location): self
    {
        $this->Location = $Location;
        $Location->setOpen(true);

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

    /**
     * @return Collection|Expenses[]
     */
    public function getExpenses(): Collection
    {
        return $this->Expenses;
    }

    public function addExpense(Expenses $expense): self
    {
        if (!$this->Expenses->contains($expense)) {
            $this->Expenses[] = $expense;
            $expense->setDay($this);
        }

        return $this;
    }

    public function removeExpense(Expenses $expense): self
    {
        if ($this->Expenses->contains($expense)) {
            $this->Expenses->removeElement($expense);
            // set the owning side to null (unless already changed)
            if ($expense->getDay() === $this) {
                $expense->setDay(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sold[]
     */
    public function getSold(): Collection
    {
        return $this->Sold;
    }

    public function addSold(Sold $sold): self
    {
        if (!$this->Sold->contains($sold)) {
            $this->Sold[] = $sold;
            $sold->setDay($this);
        }

        return $this;
    }

    public function removeSold(Sold $sold): self
    {
        if ($this->Sold->contains($sold)) {
            $this->Sold->removeElement($sold);
            // set the owning side to null (unless already changed)
            if ($sold->getDay() === $this) {
                $sold->setDay(null);
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
        $Location = $this->Location;
        $Location->setOpen = $Open;

        return $this;
    }

    /**
     * @return Collection|Worker[]
     */
    public function getWorker(): Collection
    {
        return $this->Worker;
    }

    public function addWorker(Worker $worker): self
    {
        if (!$this->Worker->contains($worker)) {
            $this->Worker[] = $worker;
            $worker->setDay($this);
        }

        return $this;
    }

    public function removeWorker(Worker $worker): self
    {
        if ($this->Worker->contains($worker)) {
            $this->Worker->removeElement($worker);
            // set the owning side to null (unless already changed)
            if ($worker->getDay() === $this) {
                $worker->setDay(null);
            }
        }

        return $this;
    }


}
