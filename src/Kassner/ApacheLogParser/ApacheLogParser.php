<?php

namespace Kassner\ApacheLogParser;

class ApacheLogParser
{

    private $format;
    private $pcreFormat;
    private $patterns = array(
        '%a' => '(?P<remoteIp>\d+\.\d+\.\d+\.\d+)',
        '%A' => '(?P<localIp>\d+\.\d+\.\d+\.\d+)',
        '%v' => '(?P<serverName>[a-z0-9.-]*)',
        '%h' => '(?P<host>\d+\.\d+\.\d+\.\d+)',
        '%l' => '(?P<logname>(?:-|\w+))',
        '%u' => '(?P<user>(?:-|\w+))',
        '%t' => '\[(?P<time>\d{2}/(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)/\d{4}:\d{2}:\d{2}:\d{2} (?:-|\+)\d{4})\]',
        '%p' => '(?P<port>\d+)',
        '%r' => '(?P<request>(?:(?:[A-Z]+) .+? HTTP/1.(?:0|1))|-)',
        '%>s' => '(?P<status>\d{3}|-)',
        '%O' => '(?P<sentBytes>\d+)',
        '%U' => '(?P<URL>.+?)',
        '\%\{(?P<name>[a-zA-Z]+)(?P<name2>[-]?)(?P<name3>[a-zA-Z]+)\}i' => '(?P<Header\\1\\3>.+?)',
    );

    public function __construct($format)
    {
        $this->format = $format;
        $this->buildPcreFormat();
    }

    public function parse($line)
    {
        if (!preg_match($this->pcreFormat, $line, $matches)) {
            throw new FormatException();
        }

        $entry = new \stdClass();

        foreach ($matches as $key => $value) {
            if (is_numeric($key)) {
                continue;
            }

            $entry->{$key} = $value;
        }

        return $entry;
    }

    protected function buildPcreFormat()
    {
        $this->pcreFormat = "#^{$this->format}$#";

        foreach ($this->patterns as $pattern => $replace) {
            $this->pcreFormat = preg_replace("/{$pattern}/", $replace, $this->pcreFormat);
        }

        $this->pcreFormat;
    }

}