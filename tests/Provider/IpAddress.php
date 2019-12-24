<?php

namespace Kassner\Tests\LogParser\Provider;

class IpAddress extends \PHPUnit_Framework_TestCase
{
    public function successProvider()
    {
        return array(
            /* IPv4 */
            array('192.168.1.1'),
            array('192.168.001.01'),
            array('172.16.0.1'),
            array('192.168.0.255'),
            array('8.8.8.8'),
            // not sure about those 2. They are valid ip-format, but can't be assigned as server address
            array('0.0.0.0'),
            array('255.255.255.255'),

            /* IPv6 */
            array('1:2:3:4:5:6:7:8'),
            array('::2:3:4:5:6:7:8'),
            array('1:2:3:4:5:6:7::'),
            array('1:2:3::6:7:8'),
            array('fff1:fff2:fff3:fff4:fff5:fff6:fff7:fff8'),
            array('FFF1:FFF2:FFF3:FFF4:FFF5:FFF6:FFF7:FFF8'),
        );
    }

    public function invalidProvider()
    {
        return array(
            /* IPv4 */
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
            // letters
            array('abc'),
            array('192.168.1.x'),
            array('insert-ip-address-here'),
            array('a.b.c.d'),
            array(' '),

            /* IPv6 */
            array('g:2:3:4:5:6:7:8'),
            array('1::3:4:5:6::8'),
            array('::4::'),
            array(':::2:3:4:5:6:7:8'),
            array('1:2:3:4:5:6:7:::'),
            array('::2::4:5:6:7:8'),
            array('1:2:3:4:5::7::'),
            array('1:2:3:::6:7:8'),
            array('fff1:ffff2:fff3:fff4:fff5:fff6:fff7:fff8'),
        );
    }
}
