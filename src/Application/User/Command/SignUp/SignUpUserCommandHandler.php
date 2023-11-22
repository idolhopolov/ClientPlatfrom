<?php

declare(strict_types=1);

namespace App\Application\User\Command\SignUp;

use App\Application\Common\Command\CommandHandlerInterface;
use App\Domain\User\Factory\UserFactoryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class SignUpUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private UserFactoryInterface $factory
    )
    {
    }

    public function __invoke(SignUpUserCommand $command): void
    {
        $user = $this->factory->makeFromPayload($command->payload);

        $this->repository->save($user);
        $this->repository->flush();
    }
}