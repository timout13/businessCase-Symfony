<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    private $birthday;

    #[ORM\Column(type: 'string', length: 255)]
    private $genre;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\PositiveOrZero(null,message: 'Le numéro de rue doit être supérieur ou égal à 0.')]
    #[Assert\Length(
        min: 1,
        max: 3,
        minMessage: 'Votre numéro doit contenir {{ limit }} charactères au minimum.',
        maxMessage: 'Votre numéro doit contenir {{ limit }} charactères au maximum.',
    )]
    private $nbStreet;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(
        min: 10,
        max: 100,
        minMessage: 'Votre adresse doit contenir {{ limit }} charactères au minimum.',
        maxMessage: 'Votre adresse doit contenir {{ limit }} charactères au maximum.',
    )]
    private $addressLine;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\PositiveOrZero(null,message: 'Le code postal ne peux pas être négatif ou nul.')]
    #[Assert\Length(
        min: 5,
        max: 5,
        minMessage: 'Votre code postal doit contenir {{ limit }} charactères au minimum.',
        exactMessage: 'Votre code postal doit contenir exactement {{ limit }} charactères.',
        maxMessage: 'Votre code postal doit contenir {{ limit }} charactères au maximum.',
    )]
    private $postCode;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Votre ville doit contenir {{ limit }} charactères au minimum.',
        maxMessage: 'Votre ville postal doit contenir {{ limit }} charactères au maximum.',
    )]
    private $city;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Orders::class)]
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function setBirthday(string $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getNbStreet(): ?string
    {
        return $this->nbStreet;
    }

    public function setNbStreet(string $nbStreet): self
    {
        $this->nbStreet = $nbStreet;

        return $this;
    }

    public function getAddressLine(): ?string
    {
        return $this->addressLine;
    }

    public function setAddressLine(string $addressLine): self
    {
        $this->addressLine = $addressLine;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }
}
