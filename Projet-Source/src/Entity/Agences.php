<?php

namespace App\Entity;

use App\Repository\AgencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgencesRepository::class)
 */
class Agences
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
    private $NomAgence;

    /**
     * @ORM\OneToMany(targetEntity=Activites::class, mappedBy="agences", orphanRemoval=true)
     */
    private $Activites;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Countries::class, inversedBy="agences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CodePostal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Fax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Logo;

    /**
     * @ORM\Column(type="date")
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NombreEmployes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomDirecteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TelephoneDirecteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $EmailDirecteur;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Utilisateur;
    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;
    /**
     * @ORM\ManyToOne(targetEntity=Cities::class, inversedBy="agences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Ville;
    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
    public function __construct()
    {
        $this->Activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAgence(): ?string
    {
        return $this->NomAgence;
    }

    public function setNomAgence(string $NomAgence): self
    {
        $this->NomAgence = $NomAgence;

        return $this;
    }

    /**
     * @return Collection|Activites[]
     */
    public function getActivites(): Collection
    {
        return $this->Activites;
    }

    public function addActivite(Activites $activite): self
    {
        if (!$this->Activites->contains($activite)) {
            $this->Activites[] = $activite;
            $activite->setAgences($this);
        }

        return $this;
    }

    public function removeActivite(Activites $activite): self
    {
        if ($this->Activites->contains($activite)) {
            $this->Activites->removeElement($activite);
            // set the owning side to null (unless already changed)
            if ($activite->getAgences() === $this) {
                $activite->setAgences(null);
            }
        }

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getPays(): ?Countries
    {
        return $this->Pays;
    }

    public function setPays(?Countries $Pays): self
    {
        $this->Pays = $Pays;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->CodePostal;
    }

    public function setCodePostal(string $CodePostal): self
    {
        $this->CodePostal = $CodePostal;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->Fax;
    }

    public function setFax(string $Fax): self
    {
        $this->Fax = $Fax;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->Logo;
    }

    public function setLogo(string $Logo): self
    {
        $this->Logo = $Logo;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getNombreEmployes(): ?string
    {
        return $this->NombreEmployes;
    }

    public function setNombreEmployes(string $NombreEmployes): self
    {
        $this->NombreEmployes = $NombreEmployes;

        return $this;
    }

    public function getNomDirecteur(): ?string
    {
        return $this->NomDirecteur;
    }

    public function setNomDirecteur(string $NomDirecteur): self
    {
        $this->NomDirecteur = $NomDirecteur;

        return $this;
    }

    public function getTelephoneDirecteur(): ?string
    {
        return $this->TelephoneDirecteur;
    }

    public function setTelephoneDirecteur(string $TelephoneDirecteur): self
    {
        $this->TelephoneDirecteur = $TelephoneDirecteur;

        return $this;
    }

    public function getEmailDirecteur(): ?string
    {
        return $this->EmailDirecteur;
    }

    public function setEmailDirecteur(string $EmailDirecteur): self
    {
        $this->EmailDirecteur = $EmailDirecteur;

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(User $Utilisateur): self
    {
        $this->Utilisateur = $Utilisateur;

        return $this;
    }

    public function getVille(): ?Cities
    {
        return $this->Ville;
    }

    public function setVille(?Cities $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }
}
