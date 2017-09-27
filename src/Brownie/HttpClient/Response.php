<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient;

/**
 * HTTP client response.
 */
class Response
{

    /**
     * Response body.
     *
     * @var string
     */
    private $responseBody;

    /**
     * HTTP response code.
     *
     * @var int
     */
    private $httpCode;

    /**
     * Request execution time.
     *
     * @var float
     */
    private $runtime;

    /**
     * Sets response body.
     * Returns the current object.
     *
     * @param string    $responseBody   Response body.
     *
     * @return self
     */
    public function setBody($responseBody)
    {
        $this->responseBody = $responseBody;
        return $this;
    }

    /**
     * Sets HTTP response code.
     * Returns the current object.
     *
     * @param int   $httpCode   HTTP response code.
     *
     * @return self
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;
        return $this;
    }

    /**
     * Sets request execution time.
     * Returns the current object.
     *
     * @param float     $runtime        Request execution time.
     *
     * @return self
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;
        return $this;
    }

    /**
     * Returns response body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->responseBody;
    }

    /**
     * Returns HTTP response code.
     *
     * @return int
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * Returns request execution time.
     *
     * @return float
     */
    public function getRuntime()
    {
        return $this->runtime;
    }
}
