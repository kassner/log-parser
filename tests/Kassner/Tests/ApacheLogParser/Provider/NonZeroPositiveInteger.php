<?php

namespace Kassner\Tests\ApacheLogParser\Provider;

class NonZeroPositiveInteger extends \PHPUnit_Framework_TestCase
{

    public function successProvider()
    {
        /** @TODO test big numbers */
        return array(
            array('1'),
            array('1234'),
            array('99999999')
        );
    }

    public function invalidProvider()
    {
        /** @TODO test negative big numbers */
        /** @TODO test doubles */
        return array(
            array('0'),
            array('dummy 1234'),
            array('lala'),
            array('-')
        );
    }

}