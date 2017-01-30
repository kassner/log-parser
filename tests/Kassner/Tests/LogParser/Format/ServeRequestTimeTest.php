<?php

namespace Kassner\Tests\LogParser\Format;

use Kassner\LogParser\LogParser;

/**
 * @format %D
 */
class ServeRequestTimeTest extends \PHPUnit_Framework_TestCase
{
    protected $parser = null;

    protected function setUp()
    {
        $this->parser = new LogParser();
        $this->parser->setFormat('%D');
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
        $this->assertEquals($line, $entry->timeServeRequest);
    }

    /**
     * @expectedException \Kassner\LogParser\FormatException
     * @dataProvider invalidProvider
     */
    public function testInvalid($line)
    {
        $this->parser->parse($line);
    }

    public function successProvider()
    {
        return array(
            array('2966894'),
            array('4547567567'),
            array('56867'),
        );
    }

    public function invalidProvider()
    {
        return array(
            array(''),
            array(null),
            array('abc'),
            array(' '),
            array('-'),
        );
    }
}
