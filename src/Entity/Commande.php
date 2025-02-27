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

    
    #[Assert\NotBlank(message: "Le numéro de téléphone est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^\d{10}$/",
        message: "Le numéro de téléphone doit comporter exactement 10 chiffres."
    )]

    #[ORM\Column]
    private ?string $telephoneclient = null;
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(
        message: "L'email '{{ value }}' n'est pas un email valide. Exemple : username@gmail.com."
    )]
    #[ORM\Column(length: 255)]
    private ?string $emailclient = null;
    


    /**
     * @var Collection<int, Medicament>
     */
    

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

    

    public function getTelephoneclient(): ?string
    {
        return $this->telephoneclient;
    }

    public function setTelephoneclient(string $telephoneclient): static
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
     * 
     */
}