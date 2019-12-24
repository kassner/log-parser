<?php

namespace Kassner\Tests\LogParser\Provider;

class PositiveInteger extends \PHPUnit_Framework_TestCase
{
    public function successProvider()
    {
        return array(
            array('1'),
            array('1234'),
            array('99999999'),
            array('100000000000000000000000'),
            array('0'),
        );
    }

    public function invalidProvider()
    {
        return array(
            array('-1'),
            array('dummy 1234'),
            array('lala'),
            array('-'),
            array('-100000000000000000000000'),
            array('12.34'),
            array('0.0'),
            array('-0'),
        );
    }
}
