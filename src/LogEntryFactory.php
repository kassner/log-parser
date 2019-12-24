<?php

declare(strict_types=1);

namespace Kassner\LogParser;

class LogEntryFactory implements LogEntryFactoryInterface
{
    public function create(array $data): LogEntryInterface
    {
        $entry = new LogEntry();

        foreach (array_filter(array_keys($data), 'is_string') as $key) {
            $entry->{$key} = $data[$key];
        }

        if (isset($entry->time)) {
            $stamp = strtotime($entry->time);
            if (false !== $stamp) {
                $entry->stamp = $stamp;
            }
        }

        return $entry;
    }
}
