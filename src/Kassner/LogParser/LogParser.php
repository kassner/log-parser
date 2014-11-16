<?php

namespace Kassner\LogParser;

class LogParser
{

    private $pcreFormat, $patterns = array(
            '%%' => '(?P<percent>\%)',
            '%a' => '(?P<remoteIp>(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?))',
            '%A' => '(?P<localIp>(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?))',
            '%h' => '(?P<host>[a-zA-Z0-9\-\._:]+)',
            '%l' => '(?P<logname>(?:-|[\w-]+))',
            '%m' => '(?P<requestMethod>OPTIONS|GET|HEAD|POST|PUT|DELETE|TRACE|CONNECT)',
            '%p' => '(?P<port>\d+)',
            '%r' => '(?P<request>(?:(?:[A-Z]+) .+? HTTP/1.(?:0|1))|-|)',
            '%t' => '\[(?P<time>\d{2}/(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)/\d{4}:\d{2}:\d{2}:\d{2} (?:-|\+)\d{4})\]',
            '%u' => '(?P<user>(?:-|[\w-]+))',
            '%U' => '(?P<URL>.+?)',
            '%v' => '(?P<serverName>([a-zA-Z0-9]+)([a-z0-9.-]*))',
            '%V' => '(?P<canonicalServerName>([a-zA-Z0-9]+)([a-z0-9.-]*))',
            '%>s' => '(?P<status>\d{3}|-)',
            '%b' => '(?P<responseBytes>(\d+|-))',
            '%T' => '(?P<requestTime>(\d+\.?\d*))',
            '%O' => '(?P<sentBytes>[0-9]+)',
            '%I' => '(?P<receivedBytes>[0-9]+)',
            '\%\{(?P<name>[a-zA-Z]+)(?P<name2>[-]?)(?P<name3>[a-zA-Z]+)\}i' => '(?P<Header\\1\\3>.*?)',
    );

    public function __construct($format = '%h %l %u %t "%r" %>s %b')
    {
        $this->setFormat($format);
    }

    public function setFormat($format)
    {
        // strtr won't work for "complex" header patterns
        // $this->pcreFormat = strtr("#^{$format}$#", $this->patterns);
        $this->pcreFormat = "#^{$format}$#";
        foreach ($this->patterns as $pattern => $replace) {
            $this->pcreFormat = preg_replace("/{$pattern}/", $replace, $this->pcreFormat);
        }
    }

    public function parse($line)
    {
        if (!preg_match($this->pcreFormat, $line, $matches)) {
            throw new FormatException($line);
        }
        $entry = new \stdClass();
        foreach (array_filter(array_keys($matches), 'is_string') as $key) {
            if ('time' === $key && true !== $stamp = strtotime($matches[$key])) {
                $entry->stamp = $stamp;
            }
            $entry->{$key} = $matches[$key];
        }

        return $entry;
    }

    public function getPCRE()
    {
        return (string) $this->pcreFormat;
    }

}
