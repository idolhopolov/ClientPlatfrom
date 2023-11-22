<?php

declare(strict_types=1);

namespace App\Application\Film\Command\CreateFilm;

use App\Application\Common\Command\CommandInterface;
use App\Application\Film\Command\Input\DTO\FilmPayload;

readonly class CreateFilmCommand implements CommandInterface
{
    public function __construct(public FilmPayload $payload)
    {
    }
}