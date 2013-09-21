<?php

namespace Kassner\Tests\ApacheLogParser\Format;

use Kassner\ApacheLogParser\ApacheLogParser;
use Kassner\Tests\ApacheLogParser\Provider\HostName as HostNameProvider;

/**
 * @format %V
 * @description The server name according to the UseCanonicalName setting.
 */
class ServerNameTest extends HostNameProvider
{

    protected $parser = null;

    protected function setUp()
    {
        $this->parser = new ApacheLogParser();
        $this->parser->setFormat('%v');
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
        $this->assertEquals($line, $entry->serverName);
    }

    /**
     * @expectedException \Kassner\ApacheLogParser\FormatException
     * @dataProvider invalidProvider
     */
    public function testInvalid($line)
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
        $this->parser->parse($line);
    }

}