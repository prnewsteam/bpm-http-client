<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\HttpClient;

interface RequestInterface
{

    /**
     * Sets HTTP request method.
     * Returns the current object.
     *
     * @param string    $method     HTTP request method.
     *
     * @return Request
     */
    public function setMethod($method);

    /**
     * Returns HTTP request method.
     *
     * @return string
     */
    public function getMethod();

    /**
     * Sets URL request.
     * Returns the current object.
     *
     * @param string    $url    URL request.
     *
     * @return Request
     */
    public function setUrl($url);

    /**
     * Returns URL request.
     *
     * @return null|string
     */
    public function getUrl();

    /**
     * Sets request body.
     * Returns the current object.
     *
     * @param string    $body   Request body.
     *
     * @return Request
     */
    public function setBody($body);

    /**
     * Returns request body.
     *
     * @return null|string
     */
    public function getBody();

    /**
     * Sets the body data format.
     * Returns the current object.
     *
     * @param string    $bodyFormat     Body data format.
     *
     * @return Request
     */
    public function setBodyFormat($bodyFormat);

    /**
     * Returns body data format.
     *
     * @return string
     */
    public function getBodyFormat();

    /**
     * Sets the execution time of the request.
     * Returns the current object.
     *
     * @param int   $timeOut    Execution time of the request.
     *
     * @return Request
     */
    public function setTimeOut($timeOut);

    /**
     * Returns the maximum time to execute the query.
     *
     * @return int
     */
    public function getTimeOut();
}
