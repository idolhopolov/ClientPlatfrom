<?php

declare(strict_types=1);

namespace App\Domain\Film\Factory;

use App\Domain\Film\Entity\Film;
use App\Domain\Film\Entity\FilmMetadata;

interface FilmMetadataFactoryInterface
{
    public function makeFromEntity(Film $payload): FilmMetadata;

    public function setFieldList(FilmMetadata $filmMetadata, Film $payload): FilmMetadata;
}