<?php

namespace Kassner\Tests\ApacheLogParser\Format;

use Kassner\ApacheLogParser\ApacheLogParser;

/**
 * @format %I
 * @description Bytes received, including request and headers, cannot be zero. You need to enable mod_logio to use this.
 */
class BytesReceivedTest extends \PHPUnit_Framework_TestCase
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

    public function successProvider()
    {
        return array(
            array('1'),
            array('1234'),
            array('99999999')
        );
    }

    public function invalidProvider()
    {
        return array(
            array('0'),
            array('dummy 1234'),
            array('lala'),
            array('-')
        );
    }

}