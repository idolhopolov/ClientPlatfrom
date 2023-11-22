<?php

namespace App\Tests\Api\UserInterface\Film\Http\Rest;

use App\Domain\User\Entity\User;
use App\Tests\Api\ApiJsonTestCase;
use App\Domain\Film\Repository\FilmRepositoryInterface;

class CreateSingleFilmControllerJsonTest extends ApiJsonTestCase
{
    private FilmRepositoryInterface|null $filmRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->filmRepository = $this->service(FilmRepositoryInterface::class);
    }

    public function testCreateSingleFilm(): void
    {
        $this->authClient();

        $payload = [
            'name' => 'test_name',
        ];

        $this->post(
            '/api/v1/film/create',
            $payload
        );
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, 201);
        $filmRepository = $this->filmRepository->findOneBy(['name' => 'test_name']);
        $filmMetadata = $filmRepository->getFilmMetadata();

        self::assertNotEmpty($filmRepository);
        self::assertNotEmpty($filmMetadata);
        self::assertEquals('test_name', $filmRepository->getName());
        self::assertEquals(2, $filmMetadata->getWordCount());
        self::assertEquals(8, $filmMetadata->getLetterCount());
    }
}