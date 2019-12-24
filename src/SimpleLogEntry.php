<?php

declare(strict_types=1);

namespace Kassner\LogParser;

class SimpleLogEntry extends \stdClass implements LogEntryInterface
{
    /** @var int|null */
    public $stamp;
}
