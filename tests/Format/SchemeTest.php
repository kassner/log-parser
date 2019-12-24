<?php

namespace Kassner\LogParser\Tests\Format;

use Kassner\LogParser\LogParser;

/**
 * @format %S
 * @description Scheme
 */
class SchemeTest extends \PHPUnit\Framework\TestCase
{
    protected $parser = null;

    protected function setUp(): void
    {
        $this->parser = new LogParser();
        $this->parser->setFormat('%S');
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
        $this->assertEquals($line, $entry->scheme);
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
