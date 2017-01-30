<?php

if (!($loader = @include __DIR__.'/../vendor/autoload.php')) {
    die('You must set up the project dependencies, run the following commands:
wget http://getcomposer.org/composer.phar
php composer.phar install --dev
');
}

$loader->add('Kassner\\Tests\\LogParser', __DIR__);
