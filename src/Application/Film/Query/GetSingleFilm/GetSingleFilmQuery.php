<?php

declare(strict_types=1);

namespace App\Application\Film\Query\GetSingleFilm;

use App\Application\Common\Query\QueryInterface;

readonly class GetSingleFilmQuery implements QueryInterface
{
    public function __construct(public int $id)
    {
    }
}