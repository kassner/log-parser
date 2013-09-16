<?php

namespace Kassner\Tests\ApacheLogParser\Format;

use Kassner\ApacheLogParser\ApacheLogParser;
use Kassner\Tests\ApacheLogParser\Provider\NonZeroPositiveInteger as NonZeroPositiveIntegerProvider;

/**
 * @format %O
 * @description Bytes sent, including headers, cannot be zero. You need to enable mod_logio to use this.
 */
class BytesSentTest extends NonZeroPositiveIntegerProvider
{

    protected $parser = null;

    protected function setUp()
    {
        $this->parser = new ApacheLogParser();
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
     * @expectedException \Kassner\ApacheLogParser\FormatException
     * @dataProvider invalidProvider
     */
    public function testInvalid($line)
    {
        $this->parser->parse($line);
    }

}