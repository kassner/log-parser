<?php

namespace Kassner\ApacheLogParser;

class Factory
{
    public function create()
    {
        return new ApacheLogParser();
    }
}