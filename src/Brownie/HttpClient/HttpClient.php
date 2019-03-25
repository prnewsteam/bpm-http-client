<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\HttpClient;

use Brownie\HttpClient\Cookie\Cookie;
use Brownie\HttpClient\Exception\ClientException;
use Brownie\HttpClient\Header\Header;

/**
 * HTTP client.
 * Target API for HTTP request.
 */
class HttpClient
{

    /**
     * Client adapter.
     *
     * @var Client
     */
    private $client;

    /**
     * Sets incoming data.
     *
     * @param Client    $client     Client adapter.
     */
    public function __construct(Client $client)
    {
        $this->setClient($client);
    }

    /**
     * Performs a network request.
     * Returns the response.
     *
     * @param Request   $request                HTTP request params.
     * @param int       $attempts               Number of request retries.
     * @param int[]     $successfulHttpCodes    Successful Http codes.
     *
     * @return Response
     *
     * @throws ClientException
     * @throws Exception\ValidateException
     */
    public function request(Request $request, $attempts = 1, $successfulHttpCodes = [])
    {
        $request->validate();
        $response = null;
        while (1 <= $attempts) {
            $response = $this->getClient()->httpRequest($request);
            $attempts--;
            if (empty($successfulHttpCodes) || in_array($response->getHttpCode(), $successfulHttpCodes)) {
                $attempts = 0;
            }
            if (0 < $attempts) {
                usleep(1000000);
            }
        };
        if (empty($response)) {
            throw new ClientException('No requests for execution.');
        }
        return $response;
    }

    /**
     * Returns HTTP client request.
     *
     * @return Request
     */
    public function createRequest()
    {
        return new Request();
    }

    /**
     * Returns HTTP cookie.
     *
     * @param string    $name       The name of the cookie.
     * @param string    $value      The value of the cookie.
     *
     * @return Cookie
     */
    public function createCookie($name, $value)
    {
        return new Cookie(array(
            'name' => $name,
            'value' => $value
        ));
    }

    /**
     * Returns HTTP header.
     *
     * @param string    $name       Header name.
     * @param string    $value      Header value.
     *
     * @return Header
     */
    public function createHeader($name, $value)
    {
        return new Header(array(
            'name' => $name,
            'value' => $value
        ));
    }

    /**
     * Sets the request client.
     * Returns the current object.
     *
     * @param Client    $client     Client adapter.
     *
     * @return $this
     */
    private function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Returns request client.
     *
     * @return Client
     */
    private function getClient()
    {
        return $this->client;
    }
}
