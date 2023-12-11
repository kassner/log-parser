<?php

namespace Kassner\LogParser\Tests\Format;

use Kassner\LogParser\LogParser;

/**
 * @format %u
 *
 * @description The remote user
 */
class UserTest extends \PHPUnit\Framework\TestCase
{
    protected $parser;

    protected function setUp(): void
    {
        $this->parser = new LogParser();
        $this->parser->setFormat('%u');
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
        $this->assertEquals($line, $entry->user);
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
        return [
            ['-'],
            ['.'],
            ['@'],
            ['abc'],
            ['abc_def'],
            ['abc-def'],
            ['abc.def'],
            ['abc.def-ghi'],
            ['abc-def@ghi.jkl'],
        ];
    }

    public function invalidProvider()
    {
        return [
            ['abc '],
            [' '],
            ['!'],
            ['a:b'],
            ['<abc>'],
            ['a/b'],
        ];
    }
}
