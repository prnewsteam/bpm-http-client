<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient;

use Brownie\HttpClient\Exception\ValidateException;

/**
 * HTTP client request.
 */
class Request
{

    /**
     * Body data format.
     */
    const FORMAT_APPLICATION_JSON = 'application/json';

    /**
     * HTTP request method GET.
     */
    const HTTP_METHOD_GET = 'GET';

    /**
     * HTTP request method POST.
     */
    const HTTP_METHOD_POST = 'POST';

    /**
     * HTTP request method PUT.
     */
    const HTTP_METHOD_PUT = 'PUT';

    /**
     * HTTP request method DELETE.
     */
    const HTTP_METHOD_DELETE = 'DELETE';

    /**
     * HTTP request method.
     *
     * @var string
     */
    private $method = self::HTTP_METHOD_GET;

    /**
     * URL request.
     *
     * @var null|string
     */
    private $url = null;

    /**
     * Request body.
     *
     * @var null|string
     */
    private $body = null;

    /**
     * Body data format.
     *
     * @var string
     */
    private $bodyFormat = self::FORMAT_APPLICATION_JSON;

    /**
     * The maximum number of seconds allowed to execute a query.
     *
     * @var int
     */
    private $timeOut = 60;

    /**
     * An array of HTTP header fields to set.
     *
     * @var array
     */
    private $headers = array();

    /**
     * An array of GET params to set.
     *
     * @var array
     */
    private $params = array();

    /**
     * Flag of checking the server's SSL.
     *
     * @var bool
     */
    private $disableSSLValidation = false;

    /**
     * Sets HTTP request method.
     * Returns the current object.
     *
     * @param $method
     *
     * @return self
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Sets URL request.
     * Returns the current object.
     *
     * @param string    $url    URL request.
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Sets request body.
     * Returns the current object.
     *
     * @param string    $body   Request body.
     *
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Adds GET param.
     * Returns the current object.
     *
     * @param string    $name       GET parameter name.
     * @param string    $value      GET parameter value.
     *
     * @return self
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * Sets the body data format.
     * Returns the current object.
     *
     * @param string    $bodyFormat     Body data format.
     *
     * @return self
     */
    public function setBodyFormat($bodyFormat)
    {
        $this->bodyFormat = $bodyFormat;
        return $this;
    }

    /**
     * Sets the execution time of the request.
     * Returns the current object.
     *
     * @param int   $timeOut    Time in seconds.
     *
     * @return self
     */
    public function setTimeOut($timeOut)
    {
        $this->timeOut = $timeOut;
        return $this;
    }

    /**
     * Adds header.
     * Returns the current object.
     *
     * @param string    $name       Header parameter name.
     * @param string    $value      Header parameter value.
     *
     * @return self
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Returns HTTP request method.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Returns URL request.
     *
     * @return null|string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns request body.
     *
     * @return null|string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Returns GET params.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Returns body data format.
     *
     * @return string
     */
    public function getBodyFormat()
    {
        return $this->bodyFormat;
    }

    /**
     * Returns the maximum time to execute the query.
     *
     * @return int
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * Returns headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Disables of checking the server's SSL.
     * Returns the current object.
     *
     * @return self
     */
    public function disableSSLValidation()
    {
        $this->disableSSLValidation = true;
        return $this;
    }

    /**
     * Returns flag of checking the server's SSL.
     *
     * @return bool
     */
    public function isDisableSSLValidation()
    {
        return $this->disableSSLValidation;
    }

    /**
     * Validates request data.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        $url = $this->getUrl();
        if (empty($url)) {
            throw new ValidateException('No required fields: url');
        }
    }
}
