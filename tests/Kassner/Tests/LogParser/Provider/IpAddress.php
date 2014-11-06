<?php

namespace Kassner\Tests\LogParser\Provider;

class IpAddress extends \PHPUnit_Framework_TestCase
{

    public function successProvider()
    {
        return array(
            array('192.168.1.1'),
            array('192.168.001.01'),
            array('172.16.0.1'),
            array('192.168.0.255'),
            array('8.8.8.8'),
            // not sure about those 2. They are valid ip-format, but can't be assigned as server address
            array('0.0.0.0'),
            array('255.255.255.255'),
        );
    }

    public function invalidProvider()
    {
        return array(
            // over 255
            array('192.168.1.256'),
            array('256.256.256.256'),
            array('321.432.543.654'),
            // incomplete
            array('192.168.1.'),
            array('192.168.1'),
            array('192.168.'),
            array('192.168'),
            array('192.'),
            array('192'),
            array(''),
            // malformed
            array('1921.68.1.1'),
            array('192.681.1.'),
            array('.1921.68.1.1'),
            array('....'),
            array('1.9.2.'),
            array('192.168.1.1/24'),
            // letters (it' not supporting IPv6 yet...)
            array('abc'),
            array('192.168.1.x'),
            array('insert-ip-address-here'),
            array('a.b.c.d'),
            array(' '),
        );
    }

}
