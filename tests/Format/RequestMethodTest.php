<?php

namespace Kassner\LogParser\Tests\Format;

use Kassner\LogParser\LogParser;

/**
 * @format %m
 * @description The request method
 */
class RequestMethodTest extends \PHPUnit\Framework\TestCase
{
    protected $parser = null;

    protected function setUp(): void
    {
        $this->parser = new LogParser();
        $this->parser->setFormat('%m');
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
        $this->assertEquals($line, $entry->requestMethod);
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
            array('OPTIONS'),
            array('GET'),
            array('HEAD'),
            array('POST'),
            array('PUT'),
            array('DELETE'),
            array('TRACE'),
            array('CONNECT'),
        );
    }

    public function invalidProvider()
    {
        return array(
            array('GET '),
            array('OPTION'),
            array(''),
            array('GET/POST'),
            array('1'),
        );
    }
}
