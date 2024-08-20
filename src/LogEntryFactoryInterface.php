<?php

declare(strict_types=1);

namespace Kassner\LogParser;

interface LogEntryFactoryInterface
{
    /**
     * @param array<array-key, mixed> $data
     */
    public function create(array $data): LogEntryInterface;
}
