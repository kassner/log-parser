<?php

namespace Kassner\LogParser\Tests\Format;

use Kassner\LogParser\LogParser;

/**
 * @format %H
 * @description The request protocol
 */
class RequestProtocolTest extends \PHPUnit\Framework\TestCase
{
    protected $parser = null;

    protected function setUp(): void
    {
        $this->parser = new LogParser();
        $this->parser->setFormat('%H');
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
        $this->assertEquals($line, $entry->requestProtocol);
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testInvalid($line)
    {
        $this->expectException(\Kassner\LogParser\FormatException::class);
        $this->parser->parse($line);
    }

    public function successProvider()
    {
        return [
            ['HTTP/1.0'],
            ['HTTP/1.1'],
            ['HTTP/2.0'],
        ];
    }

    public function invalidProvider()
    {
        return [
            [''],
            ['HTTP/1x0'],
            ['HTTP/1x1'],
            ['HTTP/2x0'],
            ['HTTP/3.0'],
        ];
    }
}
