<?php

namespace Kassner\Tests\ApacheLogParser\Provider;

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
            /** @TODO validate a few more */
            array('.php.net'),
            array('-php.net'),
            array('php-.net'),
            array('php..net'),
            array('php.-net'),
            array('php.net.'),
            array('php.net-'),
            array('www.this-seems-a-valid-host-name-but-it-is-very-very-very-very-very-very-very-very-very-very-very-very-very-very-very-very-very-very-very-very-very-very-very-very-very-big-that-is-invalid-because-have-more-than-two-hundred-and-fifty-five-character-on-it.com')
        );
    }

}