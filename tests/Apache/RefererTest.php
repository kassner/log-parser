<?php

namespace Kassner\LogParser\Tests\Apache;

use Kassner\LogParser\LogParser;

class RefererTest extends \PHPUnit\Framework\TestCase
{
    public function testFormat()
    {
        $parser = new LogParser('%{Referer}i -> %U');

        $entry = $parser->parse('- -> /index.php');
        $this->assertEquals('/index.php', $entry->URL);
        $this->assertEquals('-', $entry->HeaderReferer);

        $entry = $parser->parse('http://ecommerce.dev/ -> /media/css/fe0e1ba295680ef4c59ccc987fca2371.css');
        $this->assertEquals('/media/css/fe0e1ba295680ef4c59ccc987fca2371.css', $entry->URL);
        $this->assertEquals('http://ecommerce.dev/', $entry->HeaderReferer);

        $entry = $parser->parse('- -> /robots.txt');
        $this->assertEquals('/robots.txt', $entry->URL);
        $this->assertEquals('-', $entry->HeaderReferer);
    }
}
