<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/i",
     *     message="Veuillez respectez le format donné"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[a-z\D\.]{3,}$/i",
     *     message="Le Prénom {{ value }} est invalid veuillez entrer un nom valid",
     *
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[a-z\D\.]{3,}$/i",
     *     message="Le Nom {{ value }} est invalid veuillez entrer un prénom valid",
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(
     *     type="numeric",
     *     message="Le Numéro {{ value }} Est Invalide !",
     * )
     */
    private $telephone;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poste;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="date")
     */
    private $inscription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $forgottenPass_token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ForgottenPassExpiration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activationToken;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $logedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;
    public function __construct()
    {
        $this->sents = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }


    public function getRoles() {
        if (empty($this->roles)) {
            return ['ROLE_USER'];
        }
        return $this->roles;
    }

    public function getRooles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles=$roles;
    }

    function addRole($role) {
        $this->roles=null;
        $this->roles[] = $role;
    }



    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
            $this->nom,
            $this->prenom,
            $this->dateNaissance,
            $this->telephone,
            $this->etat,

        ]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($string)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            $this->nom,
            $this->prenom,
            $this->dateNaissance,
            $this->telephone,
            $this->etat
            ) = unserialize($string,['allowed_classes'=>false]);
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @inheritDoc
     */
    public function getRole()
    {
        return $this->role;
    }

    public function addUser()
    {

    }

    public function getInscription(): ?\DateTimeInterface
    {
        return $this->inscription;
    }

    public function setInscription(\DateTimeInterface $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getForgottenPassToken(): ?string
    {
        return $this->forgottenPass_token;

    }

    public function setForgottenPassToken(?string $forgottenPass_token): self
    {
        $this->forgottenPass_token = $forgottenPass_token;

        return $this;
    }

    public function getForgottenPassExpiration(): ?\DateTimeInterface
    {
        return $this->ForgottenPassExpiration;
    }

    public function setForgottenPassExpiration(?\DateTimeInterface $ForgottenPassExpiration): self
    {
        $this->ForgottenPassExpiration = $ForgottenPassExpiration;

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }

    public function setActivationToken(?string $activationToken): self
    {
        $this->activationToken = $activationToken;

        return $this;
    }

    public function getLogedAt(): ?\DateTimeInterface
    {
        return $this->logedAt;
    }

    public function setLogedAt(?\DateTimeInterface $logedAt): self
    {
        $this->logedAt = $logedAt;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
