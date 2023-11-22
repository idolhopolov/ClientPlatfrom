<?php

namespace App\Tests\FixturesFactory;

use App\Domain\Film\Entity\Film;
use App\Domain\Film\Entity\FilmMetadata;

use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\Password;
use Faker\Factory as FactoryFaker;
use Faker\Generator;

class FactoryAskSpot
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = FactoryFaker::create('pl_PL');
    }

    public function createUser(array $fields): User
    {
        $entity = new User();

        $entity->setFirstName($fields['firstName'] ?? $this->faker->firstName)
            ->setLastName($fields['lastName'] ?? $this->faker->lastName)
            ->setEmail($fields['email'])
            ->setPassword(Password::encode($fields['pass']));

        return $entity;
    }

    public function createFilm(array $fields): Film
    {
        $entity = new Film();

        $entity->setName($fields['name'] ?? $this->faker->name)
            ->computeSlug()
            ->setFilmMetadata($fields['filmMetadataEntity'] ?? null);
        return $entity;
    }

    public function createFilmMetadata(array $fields): FilmMetadata
    {
        $entity = new FilmMetadata();

        /** @var Film $filmEntity*/
        $filmEntity = $fields['filmEntity'];

        $entity->setFilm($filmEntity)
            ->setWordCount($filmEntity->getSlug()->getWordCount())
            ->setLetterCount($filmEntity->getSlug()->getLetterCount());

        return $entity;
    }
}