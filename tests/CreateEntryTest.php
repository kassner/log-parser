<?php

namespace Kassner\LogParser\Tests;

use Kassner\LogParser\LogParser;
use Kassner\LogParser\Tests\Entry\Fake as FakeEntry;

class CreateEntryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateEnty()
    {
        $parser = new LogParser('%h');
        $entry = $parser->parse('66.249.74.132');

        $this->assertInstanceOf(\stdClass::class, $entry);
    }

    public function testCreateEntyMocked()
    {
        $mock = $this->getMockBuilder(\Kassner\LogParser\LogParser::class)
            ->setConstructorArgs(['%h'])
            ->setMethods(['createEntry'])
            ->getMock();

        $mock->expects($this->any())->method('createEntry')->willReturn(new FakeEntry());

        $entry = $mock->parse('66.249.74.132');

        $this->assertInstanceOf(\Kassner\LogParser\Tests\Entry\Fake::class, $entry);
        $this->assertEquals($entry->host, '66.249.74.132');
    }
}
