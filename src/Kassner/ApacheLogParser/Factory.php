<?php

namespace Kassner\ApacheLogParser;

class Factory
{
    public static function create()
    {
        return new ApacheLogParser();
    }
}