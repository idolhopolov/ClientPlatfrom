<?php

declare(strict_types=1);

namespace App\Domain\Film\Entity;

use App\Domain\Film\Repository\FilmMetadataRepositoryInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity(repositoryClass: FilmMetadataRepositoryInterface::class)]
#[ORM\Table(name: '`film_metadata`')]
class FilmMetadata
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: 'letter_count')]
    private int $letterCount;

    #[ORM\Column(name: 'word_count')]
    private int $wordCount;

    #[OneToOne(inversedBy: 'filmMetadata', targetEntity: Film::class)]
    #[JoinColumn(name: 'film_id', referencedColumnName: 'id', nullable: false)]
    private Film $film;


    public function getId(): int
    {
        return $this->id;
    }

    public function getLetterCount(): int
    {
        return $this->letterCount;
    }

    public function setLetterCount(int $letterCount): static
    {
        $this->letterCount = $letterCount;
        return $this;
    }

    public function getWordCount(): int
    {
        return $this->wordCount;
    }

    public function setWordCount(int $wordCount): static
    {
        $this->wordCount = $wordCount;
        return $this;
    }

    public function getFilm(): Film
    {
        return $this->film;
    }

    public function setFilm(Film $film): static
    {
        $this->film = $film;
        return $this;
    }
}