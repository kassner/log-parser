<?php

namespace Kassner\Tests\LogParser;

use Kassner\LogParser\LogParser;
use Kassner\Tests\LogParser\Entry\Fake as FakeEntry;

class CreateEntryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateEnty()
    {
        $parser = new LogParser('%h');
        $entry = $parser->parse('66.249.74.132');

        // Not using \stdClass::class because it's available on PHP5.5+ only
        $this->assertInstanceOf('\stdClass', $entry);
    }

    public function testCreateEntyMocked()
    {
        $mock = $this->getMock('\Kassner\LogParser\LogParser', array('createEntry'), array('%h'));
        $mock->expects($this->any())->method('createEntry')->willReturn(new FakeEntry());

        $entry = $mock->parse('66.249.74.132');

        // Not using \stdClass::class because it's available on PHP5.5+ only
        $this->assertInstanceOf('\Kassner\Tests\LogParser\Entry\Fake', $entry);
        $this->assertEquals($entry->host, '66.249.74.132');
    }
}
