<?php

declare(strict_types=1);

namespace App\Domain\Film\Entity;

use App\Domain\Film\Repository\FilmRepositoryInterface;
use App\Domain\Film\ValueObject\Slug;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity(repositoryClass: FilmRepositoryInterface::class)]
#[ORM\Table(name: '`film`')]
#[ORM\Index(
    columns: ['slug'],
    name: 'film_slug_idx'
)]
#[ORM\UniqueConstraint(fields: ['slug'])]
#[ORM\HasLifecycleCallbacks]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: 'name', length: 255)]
    private string $name;

    #[ORM\Column(name: 'slug', type: 'slug', length: 255)]
    private Slug $slug;

    #[OneToOne(mappedBy: 'film', targetEntity: FilmMetadata::class, cascade: ['persist'])]
    private FilmMetadata|null $filmMetadata = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug(): Slug
    {
        return $this->slug;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function computeSlug(): static
    {
        $this->slug = Slug::makeFromString($this->getName());
        return $this;
    }

    public function getFilmMetadata(): ?FilmMetadata
    {
        return $this->filmMetadata;
    }

    public function setFilmMetadata(FilmMetadata|null $filmMetadata): static
    {
        $this->filmMetadata = $filmMetadata;
        return $this;
    }
}