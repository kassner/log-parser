<?php

namespace Kassner\LogParser\Tests\Format;

use Kassner\LogParser\LogParser;

/**
 * @description Test the various port number format strings %p %{local}p, %{remote}p and %{canonical}p
 */
class PortNumbersTest extends \PHPUnit\Framework\TestCase
{
    protected $parser = null;

    protected function setUp(): void
    {
        $this->parser = new LogParser();
    }

    protected function tearDown(): void
    {
        $this->parser = null;
    }

    /**
     * @dataProvider successProvider
     */
    public function testPortSuccess($line)
    {
        $this->parser->setFormat('%p');
        $entry = $this->parser->parse($line);
        $this->assertEquals($line, $entry->port);
	$this->assertObjectNotHasAttribute('localPort', $entry);
	$this->assertObjectNotHasAttribute('remotePort', $entry);
	$this->assertObjectNotHasAttribute('canonicalPort', $entry);
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testPortInvalid($line)
    {
        $this->parser->setFormat('%p');
        $this->expectException(\Kassner\LogParser\FormatException::class);
        $this->parser->parse($line);
    }

    /**
     * @dataProvider successProvider
     */
    public function testLocalPortSuccess($line)
    {
        $this->parser->setFormat('%{local}p');
        $entry = $this->parser->parse($line);
        $this->assertEquals($line, $entry->localPort);
	$this->assertObjectNotHasAttribute('port', $entry);
	$this->assertObjectNotHasAttribute('remotePort', $entry);
	$this->assertObjectNotHasAttribute('canonicalPort', $entry);
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testLocalPortInvalid($line)
    {
        $this->parser->setFormat('%{local}p');
        $this->expectException(\Kassner\LogParser\FormatException::class);
        $this->parser->parse($line);
    }

    /**
     * @dataProvider successProvider
     */
    public function testRemotePortSuccess($line)
    {
        $this->parser->setFormat('%{remote}p');
        $entry = $this->parser->parse($line);
        $this->assertEquals($line, $entry->remotePort);
	$this->assertObjectNotHasAttribute('port', $entry);
	$this->assertObjectNotHasAttribute('localPort', $entry);
	$this->assertObjectNotHasAttribute('canonicalPort', $entry);
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testRemotePortInvalid($line)
    {
        $this->parser->setFormat('%{remote}p');
        $this->expectException(\Kassner\LogParser\FormatException::class);
        $this->parser->parse($line);
    }
    /**
     * @dataProvider successProvider
     */
    public function testCanonicalPortSuccess($line)
    {
        $this->parser->setFormat('%{canonical}p');
        $entry = $this->parser->parse($line);
        $this->assertEquals($line, $entry->canonicalPort);
	$this->assertObjectNotHasAttribute('port', $entry);
	$this->assertObjectNotHasAttribute('localPort', $entry);
	$this->assertObjectNotHasAttribute('remotePort', $entry);
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testCanonicalPortInvalid($line)
    {
        $this->parser->setFormat('%{canonical}p');
        $this->expectException(\Kassner\LogParser\FormatException::class);
        $this->parser->parse($line);
    }

    public function successProvider()
    {
        return [
            ['443'],
            ['80'],
            ['123423']
        ];
    }

    public function invalidProvider()
    {
        return [
            [''],
            ['Nan'],
            ['+Inf'],
            ['1.6e-19']
        ];
    }
}
