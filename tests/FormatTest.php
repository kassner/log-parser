<?php

use Kassner\ApacheLog\Parser;

class FormatsTest extends \PHPUnit_Framework_TestCase
{

    public function testRemoteIpFormat()
    {
        $parser = new Parser('%a');
        $entry = $parser->parse('192.168.1.2');
        $this->assertEquals('192.168.1.2', $entry->remoteIp);
    }

    public function testLocalIpFormat()
    {
        $parser = new Parser('%A');
        $entry = $parser->parse('127.0.0.1');
        $this->assertEquals('127.0.0.1', $entry->localIp);
    }

    public function testServerName()
    {
        $parser = new Parser('%v');

        $entry = $parser->parse('localhost');
        $this->assertEquals('localhost', $entry->serverName);

        $entry = $parser->parse('localhost.localdomain');
        $this->assertEquals('localhost.localdomain', $entry->serverName);

        $entry = $parser->parse('php.net');
        $this->assertEquals('php.net', $entry->serverName);

        $entry = $parser->parse('some-ugly-and-giant-server-name.with.lots.of.subdomains.io');
        $this->assertEquals('some-ugly-and-giant-server-name.with.lots.of.subdomains.io', $entry->serverName);
    }

}