<?php

namespace App\Domain\User\Type;

enum UserRoleType: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
}