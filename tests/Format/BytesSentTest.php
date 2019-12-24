<?php

namespace Kassner\LogParser\Tests\Format;

use Kassner\LogParser\LogParser;
use Kassner\LogParser\Tests\Provider\PositiveInteger as PositiveIntegerProvider;

/**
 * @format %O
 * @description Bytes sent, including headers, cannot be zero. You need to enable mod_logio to use this.
 */
class BytesSentTest extends PositiveIntegerProvider
{
    protected $parser = null;

    protected function setUp(): void
    {
        $this->parser = new LogParser();
        $this->parser->setFormat('%O');
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
        $this->assertEquals($line, $entry->sentBytes);
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
