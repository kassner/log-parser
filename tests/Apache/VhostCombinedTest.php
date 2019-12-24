<?php

namespace Kassner\LogParser\Tests\Apache;

use Kassner\LogParser\LogParser;

class VhostCombinedTest extends \PHPUnit\Framework\TestCase
{
    public function testFormat()
    {
        $parser = new LogParser('%v:%p %h %l %u %t "%r" %>s %O "%{Referer}i" "%{User-Agent}i"');

        $entry = $parser->parse('ecommerce.dev:80 177.3.137.13 - - [11/Sep/2013:22:46:30 +0000] "GET / HTTP/1.1" 200 9726 "-" "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.65 Safari/537.36"');
        $this->assertEquals('ecommerce.dev', $entry->serverName);
        $this->assertEquals('80', $entry->port);
        $this->assertEquals('177.3.137.13', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('11/Sep/2013:22:46:30 +0000', $entry->time);
        $this->assertEquals('GET / HTTP/1.1', $entry->request);
        $this->assertEquals('200', $entry->status);
        $this->assertEquals('9726', $entry->sentBytes);
        $this->assertEquals('-', $entry->HeaderReferer);
        $this->assertEquals('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.65 Safari/537.36', $entry->HeaderUserAgent);

        $entry = $parser->parse('ecommerce.dev:80 177.3.137.13 - - [11/Sep/2013:22:46:36 +0000] "GET /media/css/fe0e1ba295680ef4c59ccc987fca2371.css HTTP/1.1" 200 36861 "http://ecommerce.dev/" "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.65 Safari/537.36"');
        $this->assertEquals('ecommerce.dev', $entry->serverName);
        $this->assertEquals('80', $entry->port);
        $this->assertEquals('177.3.137.13', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('11/Sep/2013:22:46:36 +0000', $entry->time);
        $this->assertEquals('GET /media/css/fe0e1ba295680ef4c59ccc987fca2371.css HTTP/1.1', $entry->request);
        $this->assertEquals('200', $entry->status);
        $this->assertEquals('36861', $entry->sentBytes);
        $this->assertEquals('http://ecommerce.dev/', $entry->HeaderReferer);
        $this->assertEquals('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.65 Safari/537.36', $entry->HeaderUserAgent);

        $entry = $parser->parse('ecommerce.dev:80 66.249.66.207 - - [11/Sep/2013:22:46:47 +0000] "GET /robots.txt HTTP/1.1" 503 1041 "-" "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"');
        $this->assertEquals('ecommerce.dev', $entry->serverName);
        $this->assertEquals('80', $entry->port);
        $this->assertEquals('66.249.66.207', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('11/Sep/2013:22:46:47 +0000', $entry->time);
        $this->assertEquals('GET /robots.txt HTTP/1.1', $entry->request);
        $this->assertEquals('503', $entry->status);
        $this->assertEquals('1041', $entry->sentBytes);
        $this->assertEquals('-', $entry->HeaderReferer);
        $this->assertEquals('Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', $entry->HeaderUserAgent);
    }
}
