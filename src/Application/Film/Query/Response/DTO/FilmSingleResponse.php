<?php

declare(strict_types=1);

namespace App\Application\Film\Query\Response\DTO;

use App\Application\Common\Query\Bus\DTO\ObjectResponse;
use JMS\Serializer\Annotation\Groups;

class FilmSingleResponse implements ObjectResponse
{
    #[Groups(['film_single', 'film_list'])]
    public string $name;
    #[Groups(['film_single'])]
    public string $slug;
}