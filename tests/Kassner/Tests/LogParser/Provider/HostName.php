<?php

namespace Kassner\Tests\LogParser\Provider;

class HostName extends \PHPUnit_Framework_TestCase
{
    public function successProvider()
    {
        return array(
            array('php.net'),
            array('www.php.net'),
            array('localhost'),
            array('localhost.localdomain'),
            array('pt-br.php.net'),
            array('php-net'),
        );
    }

    public function invalidProvider()
    {
        return array(
            array(''),
            /* @TODO check for invalid hostnames. In fact, there are many hostnames that are
              invalid on an internet environment, but it could be assigned a valid hostname
              on local DNS servers and VirtualHost directive */
        );
    }
}
