<?php

declare(strict_types=1);

namespace App\Application\Film\Command\Input\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

readonly class FilmPayload
{
    public function __construct(
        #[OA\Property(
            property: 'name',
            type: 'string',
            example: 'string'
        )]
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: '/\|/',  match: false)]
        public string $name
    ) {
    }
}