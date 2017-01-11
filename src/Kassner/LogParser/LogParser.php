<?php

namespace Kassner\LogParser;

class LogParser
{

    static protected $defaultFormat = '%h %l %u %t "%r" %>s %b';
    protected $pcreFormat;
    protected $ipv4 = '(((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?))';
    protected $ipv6full = '([0-9A-Fa-f]{1,4}(:[0-9A-Fa-f]{1,4}){7})'; // 1:1:1:1:1:1:1:1
    protected $ipv6null = '(::)'; // '::'
    protected $ipv6leading = '(::[0-9A-Fa-f]{1,4}(:[0-9A-Fa-f]{1,4}){0,6})'; // ::1:1:1:1:1:1:1
    protected $ipv6mid = '([0-9A-Fa-f]{1,4}(:[0-9A-Fa-f]{1,4}){0,5}:(:[0-9A-Fa-f]{1,4}){1,6})'; // 1:1:1::1:1:1
    protected $ipv6trailing = '([0-9A-Fa-f]{1,4}(:[0-9A-Fa-f]{1,4}){0,6}::)'; // 1:1:1:1:1:1:1::
    protected $ip = join('|', array($ipv4, $ipv6full, $ipv6null, $ipv6leading, $ipv6mid, $ipv6trailing));
    protected $patterns = array(
        '%%' => '(?P<percent>\%)',
        '%a' => '(?P<remoteIp>' . $ip . ')',
        '%A' => '(?P<localIp>' . $ip . ')',
        '%h' => '(?P<host>[a-zA-Z0-9\-\._:]+)',
        '%l' => '(?P<logname>(?:-|[\w-]+))',
        '%m' => '(?P<requestMethod>OPTIONS|GET|HEAD|POST|PUT|DELETE|TRACE|CONNECT|PATCH|PROPFIND)',
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
        '%D' => '(?P<timeServeRequest>[0-9]+)',
    );

    /**
     * @return string
     */
    public static function getDefaultFormat()
    {
        return self::$defaultFormat;
    }

    public function __construct($format = null)
    {
        $this->setFormat($format ?: self::getDefaultFormat());
    }

    public function addPattern($placeholder, $pattern)
    {
        $this->patterns[$placeholder] = $pattern;
    }

    public function setFormat($format)
    {
        // strtr won't work for "complex" header patterns
        // $this->pcreFormat = strtr("#^{$format}$#", $this->patterns);
        $expr = "#^{$format}$#";

        foreach ($this->patterns as $pattern => $replace) {
            $expr = preg_replace("/{$pattern}/", $replace, $expr);
        }

        $this->pcreFormat = $expr;
    }

    /**
     * Parses one single log line
     *
     * @param string $line
     * @return \stdClass
     * @throws FormatException
     */
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
