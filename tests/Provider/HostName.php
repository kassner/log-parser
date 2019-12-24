<?php

namespace Kassner\LogParser\Tests\Provider;

class HostName extends \PHPUnit\Framework\TestCase
{
    public function successProvider()
    {
        return [
            ['php.net'],
            ['www.php.net'],
            ['localhost'],
            ['localhost.localdomain'],
            ['pt-br.php.net'],
            ['php-net'],
        ];
    }

    public function invalidProvider()
    {
        return [
            [''],
            /* @TODO check for invalid hostnames. In fact, there are many hostnames that are
              invalid on an internet environment, but it could be assigned a valid hostname
              on local DNS servers and VirtualHost directive */
        ];
    }
}
