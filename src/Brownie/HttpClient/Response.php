<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\HttpClient;

use Brownie\HttpClient\Cookie\CookieList;
use Brownie\HttpClient\Header\HeaderList;
use Brownie\Util\StorageArray;

/**
 * HTTP client response.
 *
 * @method Response     setBody(string $responseBody)               Sets response body.
 * @method string       getBody()                                   Returns response body.
 * @method Response     setHttpCode(int $httpCode)                  Sets HTTP response code.
 * @method int          getHttpCode()                               Returns HTTP response code.
 * @method Response     setRuntime(float $runtime)                  Sets request execution time.
 * @method float        getRuntime()                                Returns request execution time.
 * @method Response     setHttpHeaderList(HeaderList $headerList)   Sets the headers of the http response.
 * @method HeaderList   getHttpHeaderList()                         Returns the headers of the http response.
 * @method Response     setHttpCookieList(CookieList $cookieList)   Sets the cookies of the http response.
 * @method CookieList   getHttpCookieList()                         Returns the cookies of the http response.
 */
class Response extends StorageArray
{

    protected $fields = array(
        'body' => null,             // Response body.
        'httpCode' => null,         // HTTP response code.
        'runtime' => null,          // Request execution time.
        'httpHeaderList' => null,   // Header list.
        'httpCookieList' => null,   // Cookie list.
    );
}
