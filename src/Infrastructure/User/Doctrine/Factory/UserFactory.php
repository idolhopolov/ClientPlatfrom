<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Doctrine\Factory;

use App\Application\User\Command\SignUp\Input\DTO\SignUpUserPayload;
use App\Domain\User\Entity\User;
use App\Domain\User\Factory\UserFactoryInterface;
use App\Domain\User\ValueObject\Password;

class UserFactory implements UserFactoryInterface
{
    public function makeFromPayload(SignUpUserPayload $payload): User
    {
        return $this->setFieldList(new User(), $payload);
    }

    public function setFieldList(User $user, SignUpUserPayload $payload): User
    {
        return $user
            ->setFirstName($payload->firstName)
            ->setLastName($payload->lastName)
            ->setEmail($payload->email)
            ->setPassword(Password::encode($payload->password));
    }
}