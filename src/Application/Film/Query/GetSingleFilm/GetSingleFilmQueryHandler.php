<?php

declare(strict_types=1);

namespace App\Application\Film\Query\GetSingleFilm;

use App\Application\Common\Query\Bus\DTO\ObjectResponse;
use App\Application\Common\Query\QueryHandlerInterface;
use App\Application\Film\Query\Response\Transformer\FilmTransformer;
use App\Domain\Film\Repository\FilmRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetSingleFilmQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private FilmRepositoryInterface $repository,
        private FilmTransformer $transformer
    )
    {
    }

    public function __invoke(GetSingleFilmQuery $query): ObjectResponse
    {
        $film = $this->repository->find($query->id);

        return $this->transformer->makeFromEntity($film);
    }
}