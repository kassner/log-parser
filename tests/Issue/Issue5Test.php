<?php

namespace Kassner\Teste\LogParser\Issue;

use Kassner\LogParser\LogParser;

class Issue5Test extends \PHPUnit\Framework\TestCase
{
    public function testReferersAndAgents()
    {
        $parser = new LogParser('%v:%p %h %l %u %t "%r" %>s %O "%{Referer}i" "%{User-Agent}i"');
        $entry = $parser->parse('www.example.com:80 ::1 - - [27/Oct/2013:06:27:33 +0000] "OPTIONS * HTTP/1.0" 200 126 "-" "Apache/2.2.22 (Ubuntu) (internal dummy connection)"');
        $this->assertEquals('www.example.com', $entry->serverName);
        $this->assertEquals('80', $entry->port);
        $this->assertEquals('::1', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('27/Oct/2013:06:27:33 +0000', $entry->time);
        $this->assertEquals('OPTIONS * HTTP/1.0', $entry->request);
        $this->assertEquals('200', $entry->status);
        $this->assertEquals('126', $entry->sentBytes);
        $this->assertEquals('-', $entry->HeaderReferer);
        $this->assertEquals('Apache/2.2.22 (Ubuntu) (internal dummy connection)', $entry->HeaderUserAgent);
    }
}
