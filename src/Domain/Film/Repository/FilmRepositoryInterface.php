<?php

declare(strict_types=1);

namespace App\Domain\Film\Repository;

use App\Application\Film\Query\Input\DTO\FilmQueryInput;
use App\Domain\Film\Entity\Film;

/**
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface FilmRepositoryInterface
{
    public function findFiltered(FilmQueryInput $filmConstraint);

    public function save(Film $film): void;

    public function flush(): void;
}