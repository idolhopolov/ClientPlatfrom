<?php

declare(strict_types=1);

namespace App\Infrastructure\Film\Doctrine\Factory;

use App\Domain\Film\Entity\Film;
use App\Domain\Film\Entity\FilmMetadata;
use App\Domain\Film\Factory\FilmMetadataFactoryInterface;

class FilmMetadataFactory implements FilmMetadataFactoryInterface
{
    public function makeFromEntity(Film $payload): FilmMetadata
    {
        return $this->setFieldList(new FilmMetadata(), $payload);
    }

    public function setFieldList(FilmMetadata $filmMetadata, Film $payload): FilmMetadata
    {
        return $filmMetadata->setFilm($payload)
            ->setWordCount($payload->getSlug()->getWordCount())
            ->setLetterCount($payload->getSlug()->getLetterCount());
    }
}