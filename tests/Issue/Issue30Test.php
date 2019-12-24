<?php

namespace Kassner\Teste\LogParser\Issue;

use Kassner\LogParser\LogParser;

class Issue30Test extends \PHPUnit\Framework\TestCase
{
    public function testCustomFormat()
    {
        $parser = new LogParser();
        $parser->setFormat('%h %l %u %t "%r" %>s %O "%{Referer}i" "%{User-Agent}i"');
        $entry = $parser->parse('127.0.0.1 - - [25/Jun/2017:10:14:35 +0000] "GET / HTTP/1.1" 200 11576 "-" "curl/7.47.0"');

        $this->assertEquals('127.0.0.1', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('25/Jun/2017:10:14:35 +0000', $entry->time);
        $this->assertEquals('GET / HTTP/1.1', $entry->request);
        $this->assertEquals('200', $entry->status);
        $this->assertEquals('11576', $entry->sentBytes);
        $this->assertEquals('-', $entry->HeaderReferer);
        $this->assertEquals('curl/7.47.0', $entry->HeaderUserAgent);
    }
}
