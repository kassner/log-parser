<?php

namespace Kassner\Tests\ApacheLogParser\Format;

use Kassner\ApacheLogParser\ApacheLogParser;
use Kassner\Tests\ApacheLogParser\Provider\NonZeroPositiveInteger as NonZeroPositiveIntegerProvider;

/**
 * @format %I
 * @description Bytes received, including request and headers, cannot be zero. You need to enable mod_logio to use this.
 */
class BytesReceivedTest extends NonZeroPositiveIntegerProvider
{

    protected $parser = null;

    protected function setUp()
    {
        $this->parser = new ApacheLogParser();
        $this->parser->setFormat('%I');
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
        $this->assertEquals($line, $entry->receivedBytes);
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