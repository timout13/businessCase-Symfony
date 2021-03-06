<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\Length(
        min: 5,
        max: 50,
        minMessage: 'Votre nom de produit doit contenir {{ limit }} charactères au minimum.',
        maxMessage: 'Votre nom de produit doit contenir {{ limit }} charactères au maximum.',
    )]
    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[Assert\Length(
        min: 10,
        max: 250,
        minMessage: 'Votre description doit contenir {{ limit }} charactères au minimum.',
        maxMessage: 'Votre description doit contenir {{ limit }} charactères au maximum.',
    )]
    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'float')]
    #[Assert\PositiveOrZero(null,message: 'Le prix doit être supérieur ou égal à 0.')]
    private $price;

    #[Assert\PositiveOrZero(null,message: 'Le nombre d\'étoiles doit être supérieur ou égal à 0.')]
    #[ORM\Column(type: 'integer', nullable: false)]
    private $nbStar;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'product')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'products')]
    private $brand;

    #[ORM\Column(type: 'boolean')]
    private $available;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $flagship;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getdescription(): ?string
    {
        return $this->description;
    }

    public function setdescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNbStar(): ?int
    {
        return $this->nbStar;
    }

    public function setNbStar(int $nbStar): self
    {
        $this->nbStar = $nbStar;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function getFlagship(): ?bool
    {
        return $this->flagship;
    }

    public function setFlagship(?bool $flagship): self
    {
        $this->flagship = $flagship;

        return $this;
    }

}