<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\HttpClient;

use Brownie\HttpClient\Cookie\Cookie;
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
     * @param Request   $request    HTTP request params.
     *
     * @return Response
     *
     * @throws Exception\ClientException
     * @throws Exception\ValidateException
     */
    public function request(Request $request)
    {
        $request->validate();
        return $this->getClient()->httpRequest($request);
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
