<?php

declare(strict_types=1);

namespace Kassner\LogParser;

class SimpleLogEntry implements LogEntryInterface
{
    /** @var int|null */
    public $stamp;
}
