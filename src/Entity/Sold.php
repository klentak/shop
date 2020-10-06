<?php

namespace App\Entity;

use App\Repository\SoldRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SoldRepository::class)
 */
class Sold
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
    private $Product;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $Price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $PurchasePrice;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Facture;

    /**
     * @ORM\Column(type="integer")
     */
    private $Sale;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

    /**
     * @ORM\ManyToOne(targetEntity=Day::class, inversedBy="Sold")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Day;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?string
    {
        return $this->Product;
    }

    public function setProduct(string $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->Price;
    }

    public function setPrice(string $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getPurchasePrice(): ?string
    {
        return $this->PurchasePrice;
    }

    public function setPurchasePrice(string $PurchasePrice): self
    {
        $this->PurchasePrice = $PurchasePrice;

        return $this;
    }

    public function getFacture(): ?bool
    {
        return $this->Facture;
    }

    public function setFacture(bool $Facture): self
    {
        $this->Facture = $Facture;

        return $this;
    }

    public function getSale(): ?int
    {
        return $this->Sale;
    }

    public function setSale(int $Sale): self
    {
        $this->Sale = $Sale;

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

    public function getDay(): ?Day
    {
        return $this->Day;
    }

    public function setDay(?Day $Day): self
    {
        $this->Day = $Day;

        return $this;
    }
}

