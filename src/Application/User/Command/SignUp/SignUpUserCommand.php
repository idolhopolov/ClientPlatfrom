<?php

declare(strict_types=1);

namespace App\Application\User\Command\SignUp;

use App\Application\Common\Command\CommandInterface;
use App\Application\User\Command\SignUp\Input\DTO\SignUpUserPayload;

readonly class SignUpUserCommand implements CommandInterface
{
    public function __construct(
        public SignUpUserPayload $payload
    )
    {
    }
}