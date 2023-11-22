<?php

declare(strict_types=1);

namespace App\Application\Common\Command\Bus;

use App\Application\Common\Command\CommandInterface;

interface CommandBusInterface
{
    public function handle(CommandInterface $command): void;
}