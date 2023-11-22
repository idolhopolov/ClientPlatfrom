<?php

namespace App\Tests\Api\UserInterface\Film\Http\Rest;

use App\Domain\Film\Entity\Film;
use App\Domain\Film\Entity\FilmMetadata;
use App\Domain\User\Entity\User;
use App\Tests\Api\ApiJsonTestCase;

class GetListFilmControllerJsonTest extends ApiJsonTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $filmEntityV1 = $this->factory->create(Film::class, ['name' => 'monako']);
        $filmMetadataEntityV1 = $this->factory->create(FilmMetadata::class, ['filmEntity' => $filmEntityV1, 'slug' => $filmEntityV1->getSlug()]);
        $filmEntityV2 = $this->factory->create(Film::class, ['name' => 'maryna']);
        $filmMetadataEntityV2 = $this->factory->create(FilmMetadata::class, ['filmEntity' => $filmEntityV2, 'slug' => $filmEntityV2->getSlug()]);

        $filmEntityV3 = $this->factory->create(Film::class, ['name' => 'monako_pair']);
        $filmMetadataEntityV3 = $this->factory->create(FilmMetadata::class, ['filmEntity' => $filmEntityV3, 'slug' => $filmEntityV3->getSlug()]);
        $filmEntityV4 = $this->factory->create(Film::class, ['name' => 'maryna_pair']);
        $filmMetadataEntityV4 = $this->factory->create(FilmMetadata::class, ['filmEntity' => $filmEntityV4, 'slug' => $filmEntityV4->getSlug()]);

        $filmEntityV5 = $this->factory->create(Film::class, ['name' => 'mleko']);
        $filmMetadataEntityV5 = $this->factory->create(FilmMetadata::class, ['filmEntity' => $filmEntityV5, 'slug' => $filmEntityV5->getSlug()]);
    }

    public function testGetFilmListWithRandomFilter(): void
    {
        $this->authClient();

        $this->get(
            '/api/v1/film/list?withRandom=3'
        );
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, 200);
        $result = \json_decode($response->getContent(), true);
        self::assertNotEmpty($result['data']['content']);
        self::assertCount(3, $result['data']['content']);
    }

    public function testGetFilmListWithMultipleWordsFilter(): void
    {
        $this->authClient();

        $this->get(
            '/api/v1/film/list?withMultipleWords=true'
        );
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, 200);
        $result = \json_decode($response->getContent(), true);

        self::assertNotEmpty($result['data']['content']);
        self::assertCount(2, $result['data']['content']);
    }

    public function testGetFilmListWithFirstLetterFilter(): void
    {

        $this->authClient();

        $this->get(
            '/api/v1/film/list?withFirstLetter=m'
        );
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, 200);
        $result = \json_decode($response->getContent(), true);
        self::assertNotEmpty($result['data']['content']);
        self::assertCount(4, $result['data']['content']);
    }
}