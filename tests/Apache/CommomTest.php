<?php

namespace Kassner\LogParser\Tests\Apache;

use Kassner\LogParser\LogParser;

class CommomTest extends \PHPUnit\Framework\TestCase
{
    public function testFormat()
    {
        $parser = new LogParser('%h %l %u %t "%r" %>s %O');

        $entry = $parser->parse('177.3.137.13 - - [11/Sep/2013:22:46:30 +0000] "GET / HTTP/1.1" 200 9726');
        $this->assertEquals('177.3.137.13', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('11/Sep/2013:22:46:30 +0000', $entry->time);
        $this->assertEquals('GET / HTTP/1.1', $entry->request);
        $this->assertEquals('200', $entry->status);
        $this->assertEquals('9726', $entry->sentBytes);

        $entry = $parser->parse('177.3.137.13 - - [11/Sep/2013:22:46:36 +0000] "GET /media/css/fe0e1ba295680ef4c59ccc987fca2371.css HTTP/1.1" 200 36861');
        $this->assertEquals('177.3.137.13', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('11/Sep/2013:22:46:36 +0000', $entry->time);
        $this->assertEquals('GET /media/css/fe0e1ba295680ef4c59ccc987fca2371.css HTTP/1.1', $entry->request);
        $this->assertEquals('200', $entry->status);
        $this->assertEquals('36861', $entry->sentBytes);

        $entry = $parser->parse('66.249.66.207 - - [11/Sep/2013:22:46:47 +0000] "GET /robots.txt HTTP/1.1" 503 1041');
        $this->assertEquals('66.249.66.207', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('11/Sep/2013:22:46:47 +0000', $entry->time);
        $this->assertEquals('GET /robots.txt HTTP/1.1', $entry->request);
        $this->assertEquals('503', $entry->status);
        $this->assertEquals('1041', $entry->sentBytes);
    }
}
