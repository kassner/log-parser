<?php

namespace Kassner\LogParser\Tests\Apache;

use Kassner\LogParser\LogParser;

class CombinedTest extends \PHPUnit\Framework\TestCase
{
    public function testFormat()
    {
        $parser = new LogParser('%h %l %u %t "%r" %>s %O "%{Referer}i" "%{User-Agent}i"');

        $entry = $parser->parse('177.3.137.13 - - [11/Sep/2013:22:46:30 +0000] "GET / HTTP/1.1" 200 9726 "-" "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.65 Safari/537.36"');
        $this->assertEquals('177.3.137.13', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('11/Sep/2013:22:46:30 +0000', $entry->time);
        $this->assertEquals('GET / HTTP/1.1', $entry->request);
        $this->assertEquals('200', $entry->status);
        $this->assertEquals('9726', $entry->sentBytes);
        $this->assertEquals('-', $entry->HeaderReferer);
        $this->assertEquals('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.65 Safari/537.36', $entry->HeaderUserAgent);

        $entry = $parser->parse('177.3.137.13 - - [11/Sep/2013:22:46:36 +0000] "GET /media/css/fe0e1ba295680ef4c59ccc987fca2371.css HTTP/1.1" 200 36861 "http://ecommerce.dev/" "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.65 Safari/537.36"');
        $this->assertEquals('177.3.137.13', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('11/Sep/2013:22:46:36 +0000', $entry->time);
        $this->assertEquals('GET /media/css/fe0e1ba295680ef4c59ccc987fca2371.css HTTP/1.1', $entry->request);
        $this->assertEquals('200', $entry->status);
        $this->assertEquals('36861', $entry->sentBytes);
        $this->assertEquals('http://ecommerce.dev/', $entry->HeaderReferer);
        $this->assertEquals('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.65 Safari/537.36', $entry->HeaderUserAgent);

        $entry = $parser->parse('66.249.66.207 - - [11/Sep/2013:22:46:47 +0000] "GET /robots.txt HTTP/1.1" 503 1041 "-" "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"');
        $this->assertEquals('66.249.66.207', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('11/Sep/2013:22:46:47 +0000', $entry->time);
        $this->assertEquals('GET /robots.txt HTTP/1.1', $entry->request);
        $this->assertEquals('503', $entry->status);
        $this->assertEquals('1041', $entry->sentBytes);
        $this->assertEquals('-', $entry->HeaderReferer);
        $this->assertEquals('Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', $entry->HeaderUserAgent);

        $entry = $parser->parse('177.3.137.13 - - [11/Sep/2013:19:22:43 +0000] "-" 408 0 "-" "-"');
        $this->assertEquals('177.3.137.13', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('11/Sep/2013:19:22:43 +0000', $entry->time);
        $this->assertEquals('-', $entry->request);
        $this->assertEquals('408', $entry->status);
        $this->assertEquals('0', $entry->sentBytes);
        $this->assertEquals('-', $entry->HeaderReferer);
        $this->assertEquals('-', $entry->HeaderUserAgent);

        $entry = $parser->parse('54.232.125.255 - - [07/Oct/2013:04:14:01 +0000] "" 400 0 "-" "-"');
        $this->assertEquals('54.232.125.255', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('07/Oct/2013:04:14:01 +0000', $entry->time);
        $this->assertEquals('', $entry->request);
        $this->assertEquals('400', $entry->status);
        $this->assertEquals('0', $entry->sentBytes);
        $this->assertEquals('-', $entry->HeaderReferer);
        $this->assertEquals('-', $entry->HeaderUserAgent);
    }

    public function testHttp2Format()
    {
        $parser = new LogParser('%h %l %u "%r" %>s %O "%{Referer}i" "%{User-Agent}i"');

        $entry = $parser->parse('127.0.0.1 - - "GET / HTTP/2.0" 200 10701 "-" "curl/7.54.1"');
        $this->assertEquals('127.0.0.1', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        // On my tests Apache2 returned %t empty for HTTP2 connections
        // @see https://superuser.com/questions/1222569/apache2-http2-t-logformat-is-empty
        $this->assertObjectNotHasAttribute('time', $entry);
        $this->assertEquals('GET / HTTP/2.0', $entry->request);
        $this->assertEquals('200', $entry->status);
        $this->assertEquals('10701', $entry->sentBytes);
        $this->assertEquals('-', $entry->HeaderReferer);
        $this->assertEquals('curl/7.54.1', $entry->HeaderUserAgent);
    }
}
