<?php

namespace Kassner\LogParser\Tests\Format;

use Kassner\LogParser\LogParser;
use Kassner\LogParser\Tests\Provider\IpAddress as IpAddressProvider;

class CustomPatternTest extends IpAddressProvider
{
    protected $parser;

    protected function setUp(): void
    {
        $this->parser = new LogParser();
    }

    protected function tearDown(): void
    {
        $this->parser = null;
    }

    public function testOriginalIpPattern()
    {
        $this->parser->setFormat('%a "%r"');

        $entry = $this->parser->parse('192.168.1.20 "GET / HTTP/1.1"');
        $this->assertEquals('192.168.1.20', $entry->remoteIp);

        $entry = $this->parser->parse('2001:aaaa:bbbb::cc00 "GET / HTTP/1.1"');
        $this->assertEquals('2001:aaaa:bbbb::cc00', $entry->remoteIp);
    }

    public function testCustomStringPattern()
    {
        $this->parser->addPattern('%Y', '(?P<customHost>[a-zA-Z0-9\-\._:]+)');
        $this->parser->setFormat('%h %Y %>s');

        $entry = $this->parser->parse('original.host custom.host 200');
        $this->assertEquals('custom.host', $entry->customHost);
    }

    public function testCustomIpPattern()
    {
        $this->parser->addPattern('%Y', '(?P<loadBalancer>{{PATTERN_IP_ALL}})');
        $this->parser->setFormat('%a %Y "%r"');

        $entry = $this->parser->parse('192.168.1.20 192.168.1.1 "GET / HTTP/1.1"');
        $this->assertEquals('192.168.1.1', $entry->loadBalancer);

        $entry = $this->parser->parse('192.168.1.20 2001:aaaa:bbbb::cc00 "GET / HTTP/1.1"');
        $this->assertEquals('2001:aaaa:bbbb::cc00', $entry->loadBalancer);
    }
}
