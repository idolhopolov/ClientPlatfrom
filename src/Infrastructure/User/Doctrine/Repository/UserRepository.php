<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Doctrine\Repository;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, User::class);
    }
    public function save(User $user): void
    {
        $this->em->persist($user);
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}