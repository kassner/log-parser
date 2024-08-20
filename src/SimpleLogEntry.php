<?php

declare(strict_types=1);

namespace Kassner\LogParser;

#[\AllowDynamicProperties]
class SimpleLogEntry implements LogEntryInterface
{
    /** @var int|null */
    public $stamp;
}
