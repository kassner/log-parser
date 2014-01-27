# Web server access Log Parser

[![Build Status](https://travis-ci.org/kassner/apache-log-parser.png?branch=master)](https://travis-ci.org/kassner/apache-log-parser)

## Install

Using composer:

```
php composer.phar require kassner/apache-log-parser:dev-master
```

## Usage

Simply instantiate the class :

```php
$parser = new \Kassner\ApacheLogParser\ApacheLogParser();
```

And then parse the lines of your access log file :

```php
$lines = file('/var/log/apache2/access.log', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    $entry = $parser->parse($line);
}
```

Where `$entry` object will hold all data parsed.

```php
stdClass Object
(
    [host] => 193.191.216.76
    [logname] => -
    [user] => www-data
    [stamp] => 1390794676
    [time] => 27/Jan/2014:04:51:16 +0100
    [request] => GET /wp-content/uploads/2013/11/whatever.jpg HTTP/1.1
    [status] => 200
    [responseBytes] => 58678
)
```

You may customize the log format (by default it matches the [Apache common log format](https://httpd.apache.org/docs/2.2/en/logs.html#common))

```php
# default Nginx format :
$parser->setFormat('%h %l %u %t "%r" %>s %O "%{Referer}i" \"%{User-Agent}i"');
```

## Supported format strings

Here is the list of format strings currently supported :

| Format String | Description |
| -- | ------- |
| %% | percent |
| %a | remoteIp |
| %A | localIp |
| %h | host |
| %l | logname |
| %m | requestMethod |
| %p | port |
| %r | request |
| %t | time |
| %u | user |
| %U | URL |
| %v | serverName |
| %V | canonicalServerName |
| %> | status |
| %b | responseBytes |
| %O | sentBytes |
| %I | receivedBytes |
| %{Foobar}i | The contents of Foobar: header line(s) in the request sent to the server |

Here is the full list from Apache's doc : https://httpd.apache.org/docs/2.2/en/mod/mod_log_config.html#formats

## Exceptions

If a line does not match with the defined format, an `\Kassner\ApacheLogParser\FormatException` will be thrown.