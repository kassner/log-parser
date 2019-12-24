# Web server access Log Parser

[![Build Status](https://travis-ci.org/kassner/log-parser.png?branch=master)](https://travis-ci.org/kassner/log-parser)

Parse your Apache/Nginx/Varnish/HAProxy logs into PHP objects to programatically handle the data.

## Install

```
composer require kassner/log-parser:~2.0
```

## Usage

```php
$parser = new \Kassner\LogParser\LogParser();
$lines = file('/var/log/apache2/access.log', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    $entry = $parser->parse($line);
}
```

The `$entry` object will hold all data parsed. If the line does not match the defined format, a `\Kassner\LogParser\FormatException` will be thrown.

```php
object(Kassner\LogParser\SimpleLogEntry)#4 (8) {
  ["host"]=>
  string(14) "193.191.216.76"
  ["logname"]=>
  string(1) "-"
  ["user"]=>
  string(8) "www-data"
  ["stamp"]=>
  int(1390794676)
  ["time"]=>
  string(26) "27/Jan/2014:04:51:16 +0100"
  ["request"]=>
  string(53) "GET /wp-content/uploads/2013/11/whatever.jpg HTTP/1.1"
  ["status"]=>
  string(3) "200"
  ["responseBytes"]=>
  string(5) "58678"
}
```

## Customizations

### Log format

You may customize the log format (by default it matches the [Apache common log format](https://httpd.apache.org/docs/2.2/en/logs.html#common))

```php
# default Nginx format:
$parser->setFormat('%h %l %u %t "%r" %>s %O "%{Referer}i" \"%{User-Agent}i"');
```

#### Supported format strings

Here is the full list of [log format strings](https://httpd.apache.org/docs/2.2/en/mod/mod_log_config.html#formats) supported by Apache, and whether they are supported by the library :

| Supported? | Format String | Property name | Description |
|:----------:|:-------------:|---------------|-------------|
| Y | %% | percent |The percent sign |
| Y | %>s | status |status |
| Y | %A | localIp |Local IP-address |
| Y | %a | remoteIp |Remote IP-address |
| N | %B | - |Size of response in bytes, excluding HTTP headers. |
| Y | %b | responseBytes |Size of response in bytes, excluding HTTP headers. In CLF format, i.e. a '-' rather than a 0 when no bytes are sent. |
| Y | %D | timeServeRequest | The time taken to serve the request, in microseconds. |
| N | %f | - | Filename |
| Y | %h | host |Remote host |
| X | %H | - |The request protocol (this is Apache specific) |
| Y | %I | receivedBytes | Bytes received, including request and headers, cannot be zero. You need to enable mod_logio to use this. |
| N | %k | - | Number of keepalive requests handled on this connection. Interesting if KeepAlive is being used, so that, for example, a '1' means the first keepalive request after the initial one, '2' the second, etc...; otherwise this is always 0 (Y indicating the initial request). Available in versions 2.2.11 and later. |
| Y | %l | logname | Remote logname (from identd, if supplied). This will return a dash unless mod_ident is present and IdentityCheck is set On. |
| Y | %m | requestMethod | The request method |
| Y | %O | sentBytes | Bytes sent, including headers, cannot be zero. You need to enable mod_logio to use this. |
| Y | %p | port | The canonical port of the server serving the request |
| N | %P | - | The process ID of the child that serviced the request. |
| N | %q | - | The query string (prepended with a ? if a query string exists, otherwise an empty string) |
| Y | %r | request | First line of request |
| N | %R | - | The handler generating the response (if any). |
| X | %S | scheme | This is `nginx` specific: https://nginx.org/en/docs/http/ngx_http_core_module.html#var_scheme |
| N | %s | - | Status. For requests that got internally redirected, this is the status of the *original* request --- %>s for the last. |
| X | %T | requestTime | The time taken to serve the request, in seconds. This option is not consistent, Apache won't inform the milisecond part. |
| Y | %t | time | Time the request was received (standard english format) |
| Y | %u | user | Remote user (from auth; may be bogus if return status (%s) is 401) |
| Y | %U | URL | The URL path requested, not including any query string. |
| Y | %v | serverName | The canonical ServerName of the server serving the request. |
| Y | %V | canonicalServerName | The server name according to the UseCanonicalName setting. |
| N | %X | - | Connection status when response is completed: X = connection aborted before the response completed. + = connection may be kept alive after the response is sent. - = connection will be closed after the response is sent. |
| N | %{Foobar}C | - | The contents of cookie Foobar in the request sent to the server. Only version 0 cookies are fully supported. |
| N | %{Foobar}e | - | The contents of the environment variable FOOBAR |
| Y | %{Foobar}i | *Header | The contents of Foobar: header line(s) in the request sent to the server. Changes made by other modules (e.g. mod_headers) affect this. If you're interested in what the request header was prior to when most modules would have modified it, use mod_setenvif to copy the header into an internal environment variable and log that value with the %{VARNAME}e described above. |
| N | %{Foobar}n | - | The contents of note Foobar from another module. |
| N | %{Foobar}o | - | The contents of Foobar: header line(s) in the reply. |
| N | %{format}p | - | The canonical port of the server serving the request or the server's actual port or the client's actual port. Valid formats are canonical, local, or remote. |
| N | %{format}P | - | The process ID or thread id of the child that serviced the request. Valid formats are pid, tid, and hextid. hextid requires APR 1.2.0 or higher. |
| N | %{format}t | - | The time, in the form given by format, which should be in strftime(3) format. (potentially localized) (This directive was %c in late versions of Apache 1.3, but this conflicted with the historical ssl %{var}c syntax.) |

> Beware: You should really read the notes when using a option that is marked with a `X` on the `Supported?` column.

### Entry object

Before `2.0.0` it was possible to overwrite the entry object returned by overwriting the `createEntry` method. With strict types, this is no longer possible, so instead you have to use the newly created interfaces.

First, create two new classes, your entry object and a factory that is responsible of creating it:

```php
class MyEntry implements \Kassner\LogParser\LogEntryInterface
{
}

class MyEntryFactory implements \Kassner\LogParser\LogEntryFactoryInterface
{
    public function create(array $data): \Kassner\LogParser\LogEntryInterface
    {
        // @TODO implement your code here to return a instance of MyEntry
    }
}
```

And then provide the factory as the second argument to the `LogParser` constructor:

```php
$factory = new MyEntryFactory();
$parser = new \Kassner\LogParser\LogParser(null, $factory);
$entry = $parser->parse('193.191.216.76 - www-data [27/Jan/2014:04:51:16 +0100] "GET /wp-content/uploads/2013/11/whatever.jpg HTTP/1.1" 200 58678');
```

`$entry` will be an instance of `MyEntry`.
