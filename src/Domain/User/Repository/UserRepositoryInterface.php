<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Entity\User;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function flush(): void;
}