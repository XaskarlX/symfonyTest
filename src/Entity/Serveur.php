<?php

namespace App\Entity;

use App\Repository\ServeurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServeurRepository::class)]
class Serveur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datenaissance = null;

    #[ORM\ManyToOne(inversedBy: 'serveurs')]
    private ?Restaurent $resto_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(\DateTimeInterface $datenaissance): static
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    public function getRestoId(): ?Restaurent
    {
        return $this->resto_id;
    }

    public function setRestoId(?Restaurent $resto_id): static
    {
        $this->resto_id = $resto_id;

        return $this;
    }

}
