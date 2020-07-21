<?php

namespace App\Entity;

use App\Repository\TimezonesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TimezonesRepository::class)
 */
class Timezones
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
    private $timezoneGroupeFr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $timezoneGroupeEn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $timezoneDetail;

    /**
     * @ORM\OneToMany(targetEntity=Settings::class, mappedBy="fuseau_horaire")
     */
    private $settings;

    public function __construct()
    {
        $this->settings = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimezoneGroupeFr(): ?string
    {
        return $this->timezoneGroupeFr;
    }

    public function setTimezoneGroupeFr(string $timezoneGroupeFr): self
    {
        $this->timezoneGroupeFr = $timezoneGroupeFr;

        return $this;
    }

    public function getTimezoneGroupeEn(): ?string
    {
        return $this->timezoneGroupeEn;
    }

    public function setTimezoneGroupeEn(string $timezoneGroupeEn): self
    {
        $this->timezoneGroupeEn = $timezoneGroupeEn;

        return $this;
    }

    public function getTimezoneDetail(): ?string
    {
        return $this->timezoneDetail;
    }

    public function setTimezoneDetail(string $timezoneDetail): self
    {
        $this->timezoneDetail = $timezoneDetail;

        return $this;
    }

    /**
     * @return Collection|Settings[]
     */
    public function getSettings(): Collection
    {
        return $this->settings;
    }

    public function addSetting(Settings $setting): self
    {
        if (!$this->settings->contains($setting)) {
            $this->settings[] = $setting;
            $setting->setFuseauHoraire($this);
        }

        return $this;
    }

    public function removeSetting(Settings $setting): self
    {
        if ($this->settings->contains($setting)) {
            $this->settings->removeElement($setting);
            // set the owning side to null (unless already changed)
            if ($setting->getFuseauHoraire() === $this) {
                $setting->setFuseauHoraire(null);
            }
        }

        return $this;
    }
}
