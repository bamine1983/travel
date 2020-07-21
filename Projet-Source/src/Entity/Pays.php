<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaysRepository::class)
 */
class Pays
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
    private $NomPays;

    /**
     * @ORM\OneToMany(targetEntity=Villes::class, mappedBy="pays", orphanRemoval=true)
     */
    private $Villes;

    /**
     * @ORM\OneToMany(targetEntity=Agences::class, mappedBy="Pays")
     */
    private $agences;

    public function __construct()
    {
        $this->Villes = new ArrayCollection();
        $this->agences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPays(): ?string
    {
        return $this->NomPays;
    }

    public function setNomPays(string $NomPays): self
    {
        $this->NomPays = $NomPays;

        return $this;
    }

    /**
     * @return Collection|Villes[]
     */
    public function getVilles(): Collection
    {
        return $this->Villes;
    }

    public function addVille(Villes $ville): self
    {
        if (!$this->Villes->contains($ville)) {
            $this->Villes[] = $ville;
            $ville->setPays($this);
        }

        return $this;
    }

    public function removeVille(Villes $ville): self
    {
        if ($this->Villes->contains($ville)) {
            $this->Villes->removeElement($ville);
            // set the owning side to null (unless already changed)
            if ($ville->getPays() === $this) {
                $ville->setPays(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Agences[]
     */
    public function getAgences(): Collection
    {
        return $this->agences;
    }

    public function addAgence(Agences $agence): self
    {
        if (!$this->agences->contains($agence)) {
            $this->agences[] = $agence;
            $agence->setPays($this);
        }

        return $this;
    }

    public function removeAgence(Agences $agence): self
    {
        if ($this->agences->contains($agence)) {
            $this->agences->removeElement($agence);
            // set the owning side to null (unless already changed)
            if ($agence->getPays() === $this) {
                $agence->setPays(null);
            }
        }

        return $this;
    }
}
