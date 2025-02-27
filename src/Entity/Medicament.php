<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom du médicament est obligatoire.")]
    private ?string $nom = null;

    #[ORM\Column(type: "string", length: 100)]
    #[Assert\NotBlank(message: "Le dosage est obligatoire.")]
    private ?string $dosage = null;

    #[ORM\Column(type: "string", length: 100)]
    #[Assert\NotBlank(message: "La forme du médicament est obligatoire.")]
    private ?string $forme = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    #[Assert\NotBlank(message: "Le prix est obligatoire.")]
    #[Assert\Positive(message: "Le prix doit être strictement positif.")]
    private ?float $prix = null;

    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: "La quantité en stock est obligatoire.")]
    #[Assert\PositiveOrZero]
    private ?int $quantiteenstock = null;

    #[ORM\Column(type: "date")]
    #[Assert\NotBlank(message: "La date limite de validité est obligatoire.")]
    private ?\DateTimeInterface $datelimite = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    // Getters et setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDosage(): ?string
    {
        return $this->dosage;
    }

    public function setDosage(string $dosage): self
    {
        $this->dosage = $dosage;
        return $this;
    }

    public function getForme(): ?string
    {
        return $this->forme;
    }

    public function setForme(string $forme): self
    {
        $this->forme = $forme;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getQuantiteenstock(): ?int
    {
        return $this->quantiteenstock;
    }

    public function setQuantiteenstock(int $quantiteenstock): self
    {
        $this->quantiteenstock = $quantiteenstock;
        return $this;
    }

    public function getDatelimite(): ?\DateTimeInterface
    {
        return $this->datelimite;
    }

    public function setDatelimite(\DateTimeInterface $datelimite): self
    {
        $this->datelimite = $datelimite;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
