HttpClient
==========

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
