<?php

declare(strict_types=1);

namespace Kassner\LogParser;

class LogEntryFactory implements LogEntryFactoryInterface
{
    public function create(array $data): LogEntryInterface
    {
        $entry = new LogEntry();

        foreach (array_filter(array_keys($data), 'is_string') as $key) {
            if ('time' === $key && true !== $stamp = strtotime($data[$key])) {
                $entry->stamp = $stamp;
            }

            $entry->{$key} = $data[$key];
        }

        return $entry;
    }
}
