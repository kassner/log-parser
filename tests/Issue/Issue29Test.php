<?php

namespace Kassner\Teste\LogParser\Issue;

use Kassner\LogParser\LogParser;

class Issue29Test extends \PHPUnit\Framework\TestCase
{
    public function testAuthUserWithDots()
    {
        $parser = new LogParser();
        $parser->setFormat('%h %l %u %t "%r" %>s %O "%{Referer}i" "%{User-Agent}i"');
        $entry = $parser->parse('127.0.0.1 - rafael.kassner [25/Jun/2017:10:26:04 +0000] "GET / HTTP/1.1" 200 799 "-" "curl/7.47.0"');

        $this->assertEquals('127.0.0.1', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('rafael.kassner', $entry->user);
        $this->assertEquals('25/Jun/2017:10:26:04 +0000', $entry->time);
        $this->assertEquals('GET / HTTP/1.1', $entry->request);
        $this->assertEquals('200', $entry->status);
        $this->assertEquals('799', $entry->sentBytes);
        $this->assertEquals('-', $entry->HeaderReferer);
        $this->assertEquals('curl/7.47.0', $entry->HeaderUserAgent);
    }

    public function testAuthUserAndCustomFormatUsingDots()
    {
        $parser = new LogParser();
        $parser->setFormat('%u.%t');
        $entry = $parser->parse('rafael.kassner.[25/Jun/2017:10:26:04 +0000]');

        $this->assertEquals('rafael.kassner', $entry->user);
        $this->assertEquals('25/Jun/2017:10:26:04 +0000', $entry->time);
    }
}
