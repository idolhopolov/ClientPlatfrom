<?php

declare(strict_types=1);

namespace App\Infrastructure\Film\Doctrine\Repository;

use App\Application\Film\Query\Input\DTO\FilmQueryInput;
use App\Domain\Film\Entity\Film;
use App\Domain\Film\Repository\FilmRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class FilmRepository extends ServiceEntityRepository implements FilmRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Film::class);
    }

    public function findFiltered(FilmQueryInput $filmConstraint)
    {
        $queryBuilder = $this->em->createQueryBuilder()
            ->select('f')
            ->from(Film::class, 'f')
            ->join('f.filmMetadata', 'film_metadata');

        if($firstLetter = $filmConstraint->getFirstLetter()) {
            $queryBuilder->andWhere("f.name like :firstLetter and mod(film_metadata.letterCount, 2) = 0")
                ->setParameter('firstLetter', "$firstLetter%");
        }

        if($filmConstraint->isMultipleWords()) {
            $queryBuilder->andWhere("film_metadata.wordCount > 1");
        }

        if($maxResult = $filmConstraint->getRandom()) {
           $queryBuilder->orderBy('rand()')
               ->setMaxResults($maxResult);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function save(Film $film): void
    {
        $this->em->persist($film);
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}