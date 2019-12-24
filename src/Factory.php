<?php

declare(strict_types=1);

namespace Kassner\LogParser;

class Factory
{
    public static function create(): LogParser
    {
        return new LogParser();
    }
}
