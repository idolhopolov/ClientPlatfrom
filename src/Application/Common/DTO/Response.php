<?php

declare(strict_types=1);

namespace App\Application\Common\DTO;

use JMS\Serializer\Annotation\Groups;
use OpenApi\Attributes as OA;

class Response
{
    public function __construct(
        #[Groups(['default'])]
        public int $statusCode,
        #[Groups(['default'])]
        public string $message,
        #[Groups(['default'])]
        #[OA\Property(
            property: 'data',
            type: 'mixed',
            example: ''
        )]
        public mixed $data
    ) {
    }
}
