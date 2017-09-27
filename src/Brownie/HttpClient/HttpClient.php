<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient;

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
     */
    public function request(Request $request)
    {
        $request->validate();
        return $this->getClient()->httpRequest($request);
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
