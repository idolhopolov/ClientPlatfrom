<?php

declare(strict_types=1);

namespace App\Infrastructure\Film\Doctrine\Repository;

use App\Domain\Film\Entity\FilmMetadata;
use App\Domain\Film\Repository\FilmMetadataRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class FilmMetadataRepository extends ServiceEntityRepository implements FilmMetadataRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, FilmMetadata::class);
    }
    public function save(FilmMetadata $film): void
    {
        $this->em->persist($film);
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}