<?php

namespace App\Tests\Unit\Application\Film\Command\CreateFilm;

use App\Application\Film\Command\CreateFilm\CreateFilmCommand;
use App\Application\Film\Command\CreateFilm\CreateFilmCommandHandler;
use App\Application\Film\Command\Input\DTO\FilmPayload;
use App\Domain\Film\Entity\Film;
use App\Domain\Film\Factory\FilmFactoryInterface;
use App\Domain\Film\Repository\FilmRepositoryInterface;
use App\Infrastructure\Film\Doctrine\Factory\FilmFactory;
use App\Infrastructure\Film\Doctrine\Repository\FilmRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateFilmCommandHandlerTest extends TestCase
{
    private FilmRepositoryInterface|MockObject $filmRepository;

    private FilmFactoryInterface|MockObject $filmFactory;

    private CreateFilmCommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateFilmCommandHandler(
            $this->filmFactory = $this->createMock(
                FilmFactoryInterface::class
            ),
            $this->filmRepository = $this->createMock(
                FilmRepository::class
            )
        );
    }

    /**
     * @dataProvider provideFilmName
     */
    public function testFilmCreateHandleSuccess(string $name): void
    {

        $film = $this->createMock(Film::class);

        $this->filmFactory->expects(self::once())
            ->method('makeFromPayload')
            ->willReturn($film);

        $this->filmRepository->expects(self::once())
            ->method('save')
            ->with($film);

        $this->filmRepository->expects(self::once())
            ->method('flush');

        $this->handler->__invoke(new CreateFilmCommand(new FilmPayload($name)));
    }

    /**
     * Film name array
     *
     * @return string[]
     */
    public function provideFilmName(): array
    {

        return [
            ['name_test']
        ];
    }
}