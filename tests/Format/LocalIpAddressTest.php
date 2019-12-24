<?php

namespace Kassner\LogParser\Tests\Format;

use Kassner\LogParser\LogParser;
use Kassner\LogParser\Tests\Provider\IpAddress as IpAddressProvider;

/**
 * @format %A
 * @description Local IP-address
 */
class LocalIpAddressTest extends IpAddressProvider
{
    protected $parser = null;

    protected function setUp(): void
    {
        $this->parser = new LogParser();
        $this->parser->setFormat('%A');
    }

    protected function tearDown(): void
    {
        $this->parser = null;
    }

    /**
     * @dataProvider successProvider
     */
    public function testSuccess($line)
    {
        $entry = $this->parser->parse($line);
        $this->assertEquals($line, $entry->localIp);
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testInvalid($line)
    {
        $this->expectException(\Kassner\LogParser\FormatException::class);
        $this->parser->parse($line);
    }
}
