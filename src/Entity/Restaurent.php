<?php

namespace App\Entity;

use App\Repository\RestaurentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurentRepository::class)]
class Restaurent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    /**
     * @var Collection<int, Serveur>
     */
    #[ORM\OneToMany(targetEntity: Serveur::class, mappedBy: 'resto_id')]
    private Collection $serveurs;

    public function __construct()
    {
        $this->serveurs = new ArrayCollection();
    }

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Serveur>
     */
    public function getServeurs(): Collection
    {
        return $this->serveurs;
    }

    public function addServeur(Serveur $serveur): static
    {
        if (!$this->serveurs->contains($serveur)) {
            $this->serveurs->add($serveur);
            $serveur->setRestoId($this);
        }

        return $this;
    }

    public function removeServeur(Serveur $serveur): static
    {
        if ($this->serveurs->removeElement($serveur)) {
            // set the owning side to null (unless already changed)
            if ($serveur->getRestoId() === $this) {
                $serveur->setRestoId(null);
            }
        }

        return $this;
    }
}
