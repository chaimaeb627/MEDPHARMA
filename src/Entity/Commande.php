<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datecommande = null;

    #[ORM\Column(length: 255)]
    private ?string $nomclient = null;

    #[ORM\Column(length: 255)]
    private ?string $medicammentcommande = null;

    

    #[ORM\Column]
    private ?int $telephoneclient = null;

    #[ORM\Column(length: 255)]
    private ?string $emailclient = null;

    /**
     * @var Collection<int, Medicament>
     */
    #[ORM\ManyToMany(targetEntity: Medicament::class, mappedBy: 'commande')]
    private Collection $med;

    public function __construct()
    {
        $this->med = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDatecommande(): ?\DateTimeInterface
    {
        return $this->datecommande;
    }

    public function setDatecommande(\DateTimeInterface $datecommande): static
    {
        $this->datecommande = $datecommande;

        return $this;
    }

    public function getNomclient(): ?string
    {
        return $this->nomclient;
    }

    public function setNomclient(string $nomclient): static
    {
        $this->nomclient = $nomclient;

        return $this;
    }

    public function getMedicammentcommande(): ?string
    {
        return $this->medicammentcommande;
    }

    public function setMedicammentcommande(string $medicammentcommande): static
    {
        $this->medicammentcommande = $medicammentcommande;

        return $this;
    }

    

    public function getTelephoneclient(): ?int
    {
        return $this->telephoneclient;
    }

    public function setTelephoneclient(int $telephoneclient): static
    {
        $this->telephoneclient = $telephoneclient;

        return $this;
    }

    public function getEmailclient(): ?string
    {
        return $this->emailclient;
    }

    public function setEmailclient(string $emailclient): static
    {
        $this->emailclient = $emailclient;

        return $this;
    }

    /**
     * @return Collection<int, Medicament>
     */
    public function getMed(): Collection
    {
        return $this->med;
    }

    public function addMed(Medicament $med): static
    {
        if (!$this->med->contains($med)) {
            $this->med->add($med);
            $med->addCommande($this);
        }

        return $this;
    }

    public function removeMed(Medicament $med): static
    {
        if ($this->med->removeElement($med)) {
            $med->removeCommande($this);
        }

        return $this;
    }
}
