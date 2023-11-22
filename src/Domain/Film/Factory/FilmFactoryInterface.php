<?php

declare(strict_types=1);

namespace App\Domain\Film\Factory;

use App\Application\Film\Command\Input\DTO\FilmPayload;
use App\Domain\Film\Entity\Film;

interface FilmFactoryInterface
{
    public function makeFromPayload(FilmPayload $payload): Film;

    public function setFieldList(Film $film, FilmPayload $payload): Film;
}