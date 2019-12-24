<?php

namespace Kassner\LogParser\Tests\Provider;

class IpAddress extends \PHPUnit\Framework\TestCase
{
    public function successProvider()
    {
        return [
            /* IPv4 */
            ['192.168.1.1'],
            ['192.168.001.01'],
            ['172.16.0.1'],
            ['192.168.0.255'],
            ['8.8.8.8'],
            // not sure about those 2. They are valid ip-format, but can't be assigned as server address
            ['0.0.0.0'],
            ['255.255.255.255'],

            /* IPv6 */
            ['1:2:3:4:5:6:7:8'],
            ['::2:3:4:5:6:7:8'],
            ['1:2:3:4:5:6:7::'],
            ['1:2:3::6:7:8'],
            ['fff1:fff2:fff3:fff4:fff5:fff6:fff7:fff8'],
            ['FFF1:FFF2:FFF3:FFF4:FFF5:FFF6:FFF7:FFF8'],
        ];
    }

    public function invalidProvider()
    {
        return [
            /* IPv4 */
            // over 255
            ['192.168.1.256'],
            ['256.256.256.256'],
            ['321.432.543.654'],
            // incomplete
            ['192.168.1.'],
            ['192.168.1'],
            ['192.168.'],
            ['192.168'],
            ['192.'],
            ['192'],
            [''],
            // malformed
            ['1921.68.1.1'],
            ['192.681.1.'],
            ['.1921.68.1.1'],
            ['....'],
            ['1.9.2.'],
            ['192.168.1.1/24'],
            // letters
            ['abc'],
            ['192.168.1.x'],
            ['insert-ip-address-here'],
            ['a.b.c.d'],
            [' '],

            /* IPv6 */
            ['g:2:3:4:5:6:7:8'],
            ['1::3:4:5:6::8'],
            ['::4::'],
            [':::2:3:4:5:6:7:8'],
            ['1:2:3:4:5:6:7:::'],
            ['::2::4:5:6:7:8'],
            ['1:2:3:4:5::7::'],
            ['1:2:3:::6:7:8'],
            ['fff1:ffff2:fff3:fff4:fff5:fff6:fff7:fff8'],
        ];
    }
}
