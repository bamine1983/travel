<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ModeMaintenance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomSite;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $Favicon;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $Logo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Inscription;

    /**
     * @ORM\Column(type="integer")
     */
    private $DureeSessions;

    /**
     * @ORM\Column(type="integer")
     */
    private $DureeInactivite;

    /**
     * @ORM\ManyToOne(targetEntity=Timezones::class, inversedBy="settings")
     */
    private $fuseau_horaire;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModeMaintenance(): ?bool
    {
        return $this->ModeMaintenance;
    }

    public function setModeMaintenance(bool $ModeMaintenance): self
    {
        $this->ModeMaintenance = $ModeMaintenance;

        return $this;
    }

    public function getNomSite(): ?string
    {
        return $this->NomSite;
    }

    public function setNomSite(string $NomSite): self
    {
        $this->NomSite = $NomSite;

        return $this;
    }

    public function getFavicon(): ?string
    {
        return $this->Favicon;
    }

    public function setFavicon(string $Favicon): self
    {
        $this->Favicon = $Favicon;

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

    public function getInscription(): ?bool
    {
        return $this->Inscription;
    }

    public function setInscription(bool $Inscription): self
    {
        $this->Inscription = $Inscription;

        return $this;
    }

    public function getDureeSessions(): ?int
    {
        return $this->DureeSessions;
    }

    public function setDureeSessions(int $DureeSessions): self
    {
        $this->DureeSessions = $DureeSessions;

        return $this;
    }

    public function getDureeInactivite(): ?int
    {
        return $this->DureeInactivite;
    }

    public function setDureeInactivite(int $DureeInactivite): self
    {
        $this->DureeInactivite = $DureeInactivite;

        return $this;
    }

    public function getFuseauHoraire(): ?Timezones
    {
        return $this->fuseau_horaire;
    }

    public function setFuseauHoraire(?Timezones $fuseau_horaire): self
    {
        $this->fuseau_horaire = $fuseau_horaire;

        return $this;
    }

}
