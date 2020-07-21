<?php

namespace App\Entity;

use App\Repository\SentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SentRepository::class)
 */
class Sent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnvoie;

    /**
     * @ORM\ManyToOne(targetEntity=Email::class, inversedBy="sents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idEmail;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(\DateTimeInterface $dateEnvoie): self
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    public function getIdEmail(): ?Email
    {
        return $this->idEmail;
    }

    public function setIdEmail(?Email $idEmail): self
    {
        $this->idEmail = $idEmail;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }
}
