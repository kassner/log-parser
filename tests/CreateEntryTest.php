<?php

namespace Kassner\LogParser\Tests;

use Kassner\LogParser\LogParser;

class CreateEntryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateEntryMocked()
    {
        $fakeFactory = new Entry\FakeFactory();
        $parser = new LogParser('%h', $fakeFactory);
        $entry = $parser->parse('66.249.74.132');

        $this->assertInstanceOf(Entry\Fake::class, $entry);
        $this->assertEquals($entry->host, '66.249.74.132');
    }
}
