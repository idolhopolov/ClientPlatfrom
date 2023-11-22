<?php

declare(strict_types=1);

namespace App\Application\Common\Query\Bus;

use App\Application\Common\Query\Bus\DTO\ObjectResponse;
use App\Application\Common\Query\QueryInterface;

interface QueryBusInterface
{
    public function handle(QueryInterface $query): ObjectResponse;
}