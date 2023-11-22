<?php

namespace App\Tests\Functional\Infrastructure\Film\Doctrine\Repository;

use App\Domain\Film\Entity\Film;
use App\Domain\Film\Entity\FilmMetadata;
use App\Infrastructure\Film\Doctrine\Factory\FilmMetadataFactory;
use App\Tests\FixturesFactory\DoctrineModelFactory;
use App\Tests\Functional\FunctionalTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;

class FilmMetadataRepositoryTest extends FunctionalTestCase
{
    private Film $filmEntity;
    private FilmMetadata $filmMetadataEntity;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->filmEntity = $this->factory->create(Film::class, ['name' => 'test_name']);
        $this->filmMetadataEntity = $this->factory->create(FilmMetadata::class, ['filmEntity' => $this->filmEntity, 'slug' => $this->filmEntity->getSlug()]);

    }

    protected function service(string $serviceId): mixed
    {
        return self::getContainer()->get($serviceId);
    }

    public function testFilmMetadataInsertedSuccessfully() : void
    {
        $factory = new FilmMetadataFactory();
        $filmMetadata = $factory->makeFromEntity($this->filmEntity);

        self::assertEquals($filmMetadata->getLetterCount(), $this->filmMetadataEntity->getLetterCount());
        self::assertEquals($filmMetadata->getWordCount(), $this->filmMetadataEntity->getWordCount());
    }
}