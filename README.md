# Apache Log Parser

PHP Apache Log Parser Library

[![Build Status](https://travis-ci.org/kassner/apache-log-parser.png?branch=master)](https://travis-ci.org/kassner/apache-log-parser)

## Install

Using composer:

```
{"require": {
    "kassner/apache-log-parser": "dev-master"
}}
```

## Usage

First you need to initialize and configure the format of the log file:

```
$parser = new \Kassner\ApacheLogParser\ApacheLogParser();
$parser->setFormat("%h %l %u %t \"%r\" %>s %O \"%{Referer}i\" \"%{User-Agent}i\"");
```

And then parse the lines:

```
foreach ($lines as $line) {
    $entry = $parser->parse($line);
}
```

Where `$entry` object will hold all data parsed.

## Exceptions

If a line does not match with the defined format, an `\Kassner\ApacheLogParser\FormatException` will be thrown.