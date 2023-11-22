<?php

declare(strict_types=1);

namespace App\Infrastructure\Film\Doctrine\Factory;

use App\Application\Film\Command\Input\DTO\FilmPayload;
use App\Domain\Film\Entity\Film;
use App\Domain\Film\Factory\FilmFactoryInterface;

readonly class FilmFactory implements FilmFactoryInterface
{
    public function __construct(
        private FilmMetadataFactory $filmMetadataFactory
    )
    {
    }

    public function makeFromPayload(FilmPayload $payload): Film
    {
        return $this->setFieldList(new Film(), $payload);
    }

    public function setFieldList(Film $film, FilmPayload $payload): Film
    {
        return $film
            ->setName($payload->name)
            ->computeSlug()
            ->setFilmMetadata(
                $this->filmMetadataFactory->makeFromEntity($film)
            );
    }
}