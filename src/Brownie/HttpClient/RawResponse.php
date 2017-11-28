<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient;

use Brownie\Util\StorageArray;

/**
 * Raw HTTP client response.
 *
 * @method RawResponse      setRuntime(float $runtime)                  Sets request execution time.
 * @method float            getRuntime()                                Returns request execution time.
 * @method RawResponse      setHttpCode(int $httpCode)                  Sets HTTP response code.
 * @method int              getHttpCode()                               Returns HTTP response code.
 * @method RawResponse      setHeaderSize(int $headerSize)              Sets the size of the HTTP Headers section.
 * @method int              getHeaderSize()                             Returns the size of the HTTP Headers section.
 * @method RawResponse      setResponseBody(string $responseBody)       Sets the body of the response.
 * @method string           getResponseBody()                           Returns the body of the response.
 */
class RawResponse extends StorageArray
{

    protected $fields = array(
        'runtime' => null,          // Request execution time.
        'httpCode' => null,         // HTTP response code.
        'headerSize' => null,       // Header block length.
        'responseBody' => null,     // Response body.
    );
}
