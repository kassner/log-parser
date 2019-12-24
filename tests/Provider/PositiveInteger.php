<?php

namespace Kassner\LogParser\Tests\Provider;

class PositiveInteger extends \PHPUnit\Framework\TestCase
{
    public function successProvider()
    {
        return [
            ['1'],
            ['1234'],
            ['99999999'],
            ['100000000000000000000000'],
            ['0'],
        ];
    }

    public function invalidProvider()
    {
        return [
            ['-1'],
            ['dummy 1234'],
            ['lala'],
            ['-'],
            ['-100000000000000000000000'],
            ['12.34'],
            ['0.0'],
            ['-0'],
        ];
    }
}
