<?php

declare(strict_types=1);

namespace App\Application\Film\Query\Response\DTO;

use App\Application\Common\Query\Bus\DTO\ObjectResponse;
use JMS\Serializer\Annotation\Groups;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

readonly class FilmListResponse implements ObjectResponse
{
    public function __construct(
        #[OA\Property(property: 'content', type: 'array', items: new OA\Items(ref: new Model(type: FilmSingleResponse::class), type: 'object'))]
        #[Groups(['film_list'])]
        /** @var FilmSingleResponse[]*/
        protected array $content
    )
    {
    }

    public function getContent(): array
    {
        return $this->content;
    }
}