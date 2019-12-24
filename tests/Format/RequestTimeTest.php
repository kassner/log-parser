<?php

namespace Kassner\LogParser\Tests\Format;

use Kassner\LogParser\LogParser;

/**
 * @format %T
 * @description The request time
 */
class RequestTimeTest extends \PHPUnit\Framework\TestCase
{
    protected $parser = null;

    protected function setUp(): void
    {
        $this->parser = new LogParser();
        $this->parser->setFormat('%T');
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
        $this->assertEquals($line, $entry->requestTime);
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
        return array(
            array('0.000'),
            array('1.234'),
            array('999.999'),
            // apache provides %T without the milisecond part
            array('3'),
            array('0'),
        );
    }

    public function invalidProvider()
    {
        return array(
            array('abc '),
            array(null),
            array(''),
            array(' '),
            array('-'),
        );
    }
}
