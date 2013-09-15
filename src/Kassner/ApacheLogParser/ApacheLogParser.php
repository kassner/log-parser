<?php

namespace Kassner\ApacheLogParser;

class ApacheLogParser
{

    private $format;
    private $pcreFormat;
    private $patterns = array(
        '%%' => '(?P<percent>\%)',
        '%a' => '(?P<remoteIp>\d+\.\d+\.\d+\.\d+)',
        '%A' => '(?P<localIp>\d+\.\d+\.\d+\.\d+)',
        '%h' => '(?P<host>\d+\.\d+\.\d+\.\d+)',
        '\%\{(?P<name>[a-zA-Z]+)(?P<name2>[-]?)(?P<name3>[a-zA-Z]+)\}i' => '(?P<Header\\1\\3>.+?)',
        '%l' => '(?P<logname>(?:-|\w+))',
        '%p' => '(?P<port>\d+)',
        '%r' => '(?P<request>(?:(?:[A-Z]+) .+? HTTP/1.(?:0|1))|-)',
        '%t' => '\[(?P<time>\d{2}/(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)/\d{4}:\d{2}:\d{2}:\d{2} (?:-|\+)\d{4})\]',
        '%u' => '(?P<user>(?:-|\w+))',
        '%U' => '(?P<URL>.+?)',
        '%v' => '(?P<serverName>[a-z0-9.-]*)',
        '%>s' => '(?P<status>\d{3}|-)',
        '%O' => '(?P<sentBytes>[1-9][0-9]*)',
        '%I' => '(?P<receivedBytes>[1-9][0-9]*)',
    );

    public function __construct($format = null)
    {
        if (!is_null($format)) {
            $this->setFormat($format);
        }
    }

    public function setFormat($format)
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