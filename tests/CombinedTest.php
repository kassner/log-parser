<?php

namespace Kassner\LogParser\Tests;

use Kassner\LogParser\LogParser;

class CombinedTest extends \PHPUnit\Framework\TestCase
{
    public function testCombinedFormat()
    {
        $parser = new LogParser('%h %l %u %t "%r" %>s %O "%{Referer}i" "%{User-Agent}i"');
        $entry = $parser->parse('66.249.74.132 - - [10/Sep/2013:15:50:06 +0000] "GET /electronics/cameras/accessories/universal-camera-charger HTTP/1.1" 200 12347 "-" "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"');

        $this->assertEquals('66.249.74.132', $entry->host);
        $this->assertEquals('-', $entry->logname);
        $this->assertEquals('-', $entry->user);
        $this->assertEquals('10/Sep/2013:15:50:06 +0000', $entry->time);
        $this->assertEquals('GET /electronics/cameras/accessories/universal-camera-charger HTTP/1.1', $entry->request);
        $this->assertEquals('200', $entry->status);
        $this->assertEquals('12347', $entry->sentBytes);
        $this->assertEquals('-', $entry->HeaderReferer);
        $this->assertEquals('Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', $entry->HeaderUserAgent);
    }
}
