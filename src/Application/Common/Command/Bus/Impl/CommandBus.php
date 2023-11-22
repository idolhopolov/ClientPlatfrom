<?php

declare(strict_types=1);

namespace App\Application\Common\Command\Bus\Impl;

use App\Application\Common\Command\Bus\CommandBusInterface;
use App\Application\Common\Command\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class CommandBus implements CommandBusInterface
{
    public function __construct(
        protected MessageBusInterface $bus
    )
    {
    }

    public function handle(CommandInterface $command): void
    {
        $this->bus->dispatch($command);
    }
}