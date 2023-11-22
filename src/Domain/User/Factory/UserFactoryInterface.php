<?php

namespace App\Domain\User\Factory;

use App\Application\User\Command\SignUp\Input\DTO\SignUpUserPayload;
use App\Domain\User\Entity\User;

interface UserFactoryInterface
{
    public function makeFromPayload(SignUpUserPayload $payload): User;

    public function setFieldList(User $user, SignUpUserPayload $payload): User;
}