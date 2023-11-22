<?php

namespace App\Tests\Functional\Infrastructure\Film\Doctrine\Repository;

use App\Domain\Film\Entity\Film;
use App\Tests\Functional\FunctionalTestCase;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class FilmRepositoryTest extends FunctionalTestCase
{
    /**
     * @dataProvider provideFilmName
     */
    public function testFilmIsInsertedSuccessfully(string $name) : void
    {
        $this->factory->create(Film::class, ['name' => $name]);

        $insertedProduct = $this->entityManager->getRepository(Film::class)->findOneBy([
            'name' => $name,
        ]);

        self::assertNotNull($insertedProduct);
        self::assertEquals($name, $insertedProduct->getName());
        self::assertEquals('name|test', $insertedProduct->getSlug());
    }

    /**
     * @dataProvider provideInvalidFilmName
     */
    public function testProvideInvalidFilmName(string $name) : void
    {
        $this->expectException(\UnexpectedValueException::class);

        $this->factory->create(Film::class, ['name' => $name]);
    }

    /**
     * @dataProvider provideMultipleFilmName
     */
    public function testProvideMultipleFilmName(array $nameList) : void
    {
        $this->expectException(UniqueConstraintViolationException::class);

        foreach ($nameList as $name) {

            $this->factory->create(Film::class, ['name' => $name]);
        }
    }

    /**
     * Film name array
     *
     * @return string[][]
     */
    public function provideFilmName(): array
    {

        return [
            ['name_test']
        ];
    }

    /**
     * Film name array
     *
     * @return string[][][]
     */
    public function provideMultipleFilmName(): array
    {

        return [
            [['name_test', 'name_test']]
        ];
    }

    /**
     * Film name array
     *
     * @return string[][]
     */
    public function provideInvalidFilmName(): array
    {
        return [
            ['name|test']
        ];
    }
}