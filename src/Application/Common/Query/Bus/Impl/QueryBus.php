<?php

declare(strict_types=1);

namespace App\Application\Common\Query\Bus\Impl;

use App\Application\Common\Query\Bus\DTO\ObjectResponse;
use App\Application\Common\Query\Bus\QueryBusInterface;
use App\Application\Common\Query\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

readonly class QueryBus implements QueryBusInterface
{
    public function __construct(
        protected MessageBusInterface $bus
    )
    {
    }

    public function handle(QueryInterface $query): ObjectResponse
    {
        $envelope = $this->bus->dispatch($query);

        /** @var HandledStamp $stamp */
        $stamp = $envelope->last(HandledStamp::class);

        return $stamp->getResult();
    }
}