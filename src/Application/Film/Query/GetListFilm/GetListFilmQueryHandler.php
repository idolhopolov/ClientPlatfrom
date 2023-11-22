<?php

declare(strict_types=1);

namespace App\Application\Film\Query\GetListFilm;

use App\Application\Common\Query\QueryHandlerInterface;
use App\Application\Film\Query\Response\DTO\FilmListResponse;
use App\Application\Film\Query\Response\Transformer\FilmTransformer;
use App\Domain\Film\Entity\Film;
use App\Domain\Film\Repository\FilmRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetListFilmQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private FilmRepositoryInterface $repository,
        private FilmTransformer $transformer
    )
    {
    }

    public function __invoke(GetListFilmQuery $query): FilmListResponse
    {
        $response = $this->repository->findFiltered($query->filmConstraint);

        return new FilmListResponse(
            \array_map(function (Film $item) {
                return $this->transformer->makeFromEntity($item);
            }, $response)
        );
    }
}