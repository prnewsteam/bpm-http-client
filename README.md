HttpClient
==========

[![Latest Stable Version](https://poser.pugx.org/ossbrownie/http-client/v/stable)](https://packagist.org/packages/ossbrownie/http-client)
[![Total Downloads](https://poser.pugx.org/ossbrownie/http-client/downloads)](https://packagist.org/packages/ossbrownie/http-client)
[![Latest Unstable Version](https://poser.pugx.org/ossbrownie/http-client/v/unstable)](https://packagist.org/packages/ossbrownie/http-client)
[![License](https://poser.pugx.org/ossbrownie/http-client/license)](https://packagist.org/packages/ossbrownie/http-client)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ossbrownie/http-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ossbrownie/http-client/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/ossbrownie/http-client/badge.svg?branch=master)](https://coveralls.io/github/ossbrownie/http-client?branch=master)
[![Build Status](https://travis-ci.org/ossbrownie/http-client.svg?branch=master)](https://travis-ci.org/ossbrownie/http-client)

A simple HTTP client for sending HTTP requests and receiving responses based on CURL.

## curl
A basic CURL wrapper for PHP (see [http://php.net/curl](http://php.net/curl) for more information about the libcurl extension for PHP)

## Requirements
- **PHP** >= 5.3
- **EXT-CURL** = *

## Usage
```php
$httpClient = new HttpClient(
    new CurlAdapter(new CurlAdaptee())
);

$request = new Request();
$request
    ->setMethod(Request::HTTP_METHOD_GET)
    ->setUrl('https://api.github.com/emojis')
    ->setBody('{"Hello":"World"}')
    ->addParam('page', '5555')
    ->setBodyFormat(Request::FORMAT_APPLICATION_JSON)
    ->setTimeOut(100)
    ->disableSSLValidation()
    ->addHeader('test', 'Simple');

$response = $httpClient->request($request);

echo 'HTTP Code: ' . $response->getHttpCode() . PHP_EOL;
echo 'Request runtime: ' . $response->getRuntime() . PHP_EOL;
echo 'Response body: ' . $response->getBody() . PHP_EOL;
```

## Contact

Problems, comments, and suggestions all welcome: [oss.brownie@gmail.com](mailto:oss.brownie@gmail.com)
