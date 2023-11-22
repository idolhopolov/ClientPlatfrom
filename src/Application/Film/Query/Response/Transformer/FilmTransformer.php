<?php

declare(strict_types=1);

namespace App\Application\Film\Query\Response\Transformer;

use App\Application\Film\Query\Response\DTO\FilmSingleResponse;
use App\Domain\Film\Entity\Film;

class FilmTransformer
{
    public function makeFromEntity(Film $film): FilmSingleResponse {
        $filmResponse = new FilmSingleResponse();

        $filmResponse->name = $film->getName();
        $filmResponse->slug = (string)$film->getSlug();

        return $filmResponse;
    }
}