<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient;

use Brownie\HttpClient\Exception\ValidateException;
use Brownie\HttpClient\Header\Header;
use Brownie\HttpClient\Cookie\Cookie;
use Brownie\Util\StorageArray;

/**
 * HTTP client request.
 *
 * @method Request          setMethod(string $method)           Sets HTTP request method.
 * @method string           getMethod()                         Returns HTTP request method.
 * @method Request          setUrl(string $url)                 Sets URL request.
 * @method null|string      getUrl()                            Returns URL request.
 * @method Request          setBody(string $body)               Sets request body.
 * @method null|string      getBody()                           Returns request body.
 * @method Request          setBodyFormat(string $bodyFormat)   Sets the body data format.
 * @method string           getBodyFormat()                     Returns body data format.
 * @method Request          setTimeOut(int $timeOut)            Sets the execution time of the request.
 * @method string           getTimeOut()                        Returns the maximum time to execute the query.
 */
class Request extends StorageArray
{

    /**
     * Body data formats.
     */
    const FORMAT_APPLICATION_JSON = 'application/json';

    const FORMAT_APPLICATION_XML = 'application/xml';

    const FORMAT_TEXT_HTML = 'text/html';

    const FORMAT_TEXT_PLAIN = 'text/plain';

    const FORMAT_FORM_URLENCODED = 'application/x-www-form-urlencoded';

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
     * HTTP request method HEADER.
     */
    const HTTP_METHOD_HEADER = 'HEADER';

    protected $fields = array(
        'method' => self::HTTP_METHOD_GET,              // HTTP request method.
        'url' => null,                                  // URL request.
        'body' => null,                                 // Request body.
        'bodyFormat' => self::FORMAT_FORM_URLENCODED,   // Body data format.
        'timeOut' => 60,                                // The maximum number of seconds allowed to execute a query.
    );

    /**
     * An array of HTTP header fields to set.
     *
     * @var array
     */
    private $headers = array();

    /**
     * An array of HTTP cookie fields to set.
     *
     * @var array
     */
    private $cookies = array();

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
     * Authentication data.
     *
     * @var string
     */
    private $authentication;

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
     * Adds header.
     * Returns the current object.
     *
     * @param Header    $header     Header.
     *
     * @return self
     */
    public function addHeader(Header $header)
    {
        $this->headers[$header->getName()] = $header;
        return $this;
    }

    /**
     * Adds cookie.
     * Returns the current object.
     *
     * @param Cookie    $cookie     Cookie.
     *
     * @return self
     */
    public function addCookie(Cookie $cookie)
    {
        $this->cookies[$cookie->getName()] = $cookie;
        return $this;
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
     * Returns headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Returns cookies.
     *
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
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

    /**
     * Sets authentication data.
     * Returns the current object.
     *
     * @param $login
     * @param $password
     *
     * @return self
     */
    public function setAuthentication($login, $password)
    {
        $this->authentication = $login . ':' . $password;
        return $this;
    }

    /**
     * Returns authentication data.
     *
     * @return string
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }
}
