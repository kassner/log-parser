<?php

namespace Kassner\Tests\LogParser\Format;

use Kassner\LogParser\LogParser;

/**
 * @format %S
 * @description Scheme
 */
class SchemeTest extends \PHPUnit_Framework_TestCase
{
    protected $parser = null;

    protected function setUp()
    {
        $this->parser = new LogParser();
        $this->parser->setFormat('%S');
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
        $this->assertEquals($line, $entry->scheme);
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
            array('http'),
            array('https'),
        );
    }

    public function invalidProvider()
    {
        return array(
            array('http '),
            array('ftp'),
            array(''),
            array('h2'),
            array('1'),
        );
    }
}
