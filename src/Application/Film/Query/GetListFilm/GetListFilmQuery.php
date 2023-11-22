<?php

declare(strict_types=1);

namespace App\Application\Film\Query\GetListFilm;

use App\Application\Common\Query\QueryInterface;
use App\Application\Film\Query\Input\DTO\FilmQueryInput;

readonly class GetListFilmQuery implements QueryInterface
{
    public function __construct(
        public FilmQueryInput $filmConstraint
    )
    {
    }
}