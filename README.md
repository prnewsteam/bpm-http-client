HttpClient
==========

[![Latest Stable Version](https://poser.pugx.org/ossbrownie/http-client/v/stable)](https://packagist.org/packages/ossbrownie/http-client)
[![Total Downloads](https://poser.pugx.org/ossbrownie/http-client/downloads)](https://packagist.org/packages/ossbrownie/http-client)
[![Latest Unstable Version](https://poser.pugx.org/ossbrownie/http-client/v/unstable)](https://packagist.org/packages/ossbrownie/http-client)
[![License](https://poser.pugx.org/ossbrownie/http-client/license)](https://packagist.org/packages/ossbrownie/http-client)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ossbrownie/http-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ossbrownie/http-client/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/ossbrownie/http-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ossbrownie/http-client/?branch=master)
[![Build Status](https://travis-ci.org/ossbrownie/http-client.svg?branch=master)](https://travis-ci.org/ossbrownie/http-client)

A simple HTTP client for sending HTTP requests and receiving responses.

## curl
A basic CURL wrapper for PHP (see [http://php.net/curl](http://php.net/curl) for more information about the libcurl extension for PHP)

## Requirements
- **PHP** >= 5.3
- **EXT-CURL** = *
- **"ossbrownie/util"** = ~0.0.1

## Usage
```php
$httpClient = new HttpClient(
    new CurlAdapter(new CurlAdaptee())
);

$header = new Header();
$header
    ->setName('test1')
    ->setValue('Simple1');

$cookie = new Cookie();
$cookie
    ->setName('cookieName1')
    ->setValue('cookieValue1');

$request = new Request();
$request
    ->setMethod(Request::HTTP_METHOD_GET)
    ->setUrl('https://api.github.com/emojis')
    ->setBody('{"Hello":"World"}')
    ->addParam('page', '5555')
    ->setBodyFormat(Request::FORMAT_APPLICATION_JSON)
    ->setTimeOut(100)
    ->disableSSLValidation()
    ->setAuthentication('tester', '123')
    ->addHeader(new Header(array(
        'name' => 'test2',
        'value' => 'Simple2'
    )))
    ->addHeader($header)
    ->addCookie(new Cookie(array(
        'name' => 'cookieName2',
        'value' => 'cookieValue2',
    )))
    ->addCookie($cookie);

$response = $httpClient->request($request);

echo 'HTTP Code: ' . $response->getHttpCode() . PHP_EOL;
echo 'Response header "Content-Type": ' .
    var_export(
        $response->getHttpHeaderList()->get('Content-Type')->getValue(),
        true
    ) .
    PHP_EOL;
echo 'Response cookie "test3": ' .
    var_export(
        $response->getHttpCookieList()->get('test3')->getValue(),
        true
    ) .
    PHP_EOL;
echo 'Request runtime: ' . $response->getRuntime() . PHP_EOL;
echo 'Response body: ' . $response->getBody() . PHP_EOL;
```

## Contact

Problems, comments, and suggestions all welcome: [oss.brownie@gmail.com](mailto:oss.brownie@gmail.com)
