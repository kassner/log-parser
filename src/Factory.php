<?php

namespace Kassner\LogParser;

class Factory
{
    /**
     * Creates a LogParser instance.
     *
     * @return \Kassner\LogParser\LogParser
     */
    public static function create()
    {
        return new LogParser();
    }
}
