<?php

declare(strict_types=1);

namespace App\Application\Film\Command\CreateFilm;

use App\Application\Common\Command\CommandHandlerInterface;
use App\Domain\Film\Exception\FilmException;
use App\Domain\Film\Factory\FilmFactoryInterface;
use App\Domain\Film\Repository\FilmRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateFilmCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private FilmFactoryInterface $factory,
        private FilmRepositoryInterface $repository
    )
    {
    }

    public function __invoke(CreateFilmCommand $command): void
    {

        $filmResponse = $this->factory->makeFromPayload($command->payload);

        if($this->repository->findOneBy(['slug' => $filmResponse->getSlug()])) {
            throw new FilmException('slug constraint violation');
        }

        $this->repository->save($filmResponse);
        $this->repository->flush();
    }
}