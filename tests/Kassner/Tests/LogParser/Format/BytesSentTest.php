<?php

namespace Kassner\Tests\LogParser\Format;

use Kassner\LogParser\LogParser;
use Kassner\Tests\LogParser\Provider\PositiveInteger as PositiveIntegerProvider;

/**
 * @format %O
 * @description Bytes sent, including headers, cannot be zero. You need to enable mod_logio to use this.
 */
class BytesSentTest extends PositiveIntegerProvider
{
    protected $parser = null;

    protected function setUp()
    {
        $this->parser = new LogParser();
        $this->parser->setFormat('%O');
    }

    protected function tearDown()
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
     * @expectedException \Kassner\LogParser\FormatException
     * @dataProvider invalidProvider
     */
    public function testInvalid($line)
    {
        $this->parser->parse($line);
    }
}
