<?php

declare(strict_types=1);

namespace Kassner\LogParser;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class SimpleLogEntry implements LogEntryInterface
{
    /** @var int|null */
    public $stamp;
}
