<?php

declare(strict_types=1);

namespace App\Domain\Film\Repository;

use App\Domain\Film\Entity\FilmMetadata;

/**
 * @method FilmMetadata|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilmMetadata|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilmMetadata[]    findAll()
 * @method FilmMetadata[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface FilmMetadataRepositoryInterface
{
    public function save(FilmMetadata $film): void;

    public function flush(): void;
}