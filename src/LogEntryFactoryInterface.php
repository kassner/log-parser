<?php

declare(strict_types=1);

namespace Kassner\LogParser;

interface LogEntryFactoryInterface
{
    public function create(array $data): LogEntryInterface;
}
