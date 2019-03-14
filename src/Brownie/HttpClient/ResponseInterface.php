<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\HttpClient;

use Brownie\HttpClient\Cookie\CookieList;
use Brownie\HttpClient\Header\HeaderList;

interface ResponseInterface
{

    /**
     * Sets response body.
     * Returns the current object.
     *
     * @param string    $responseBody   Response body.
     *
     * @return Response
     */
    public function setBody($responseBody);

    /**
     * Returns response body.
     *
     * @return string
     */
    public function getBody();

    /**
     * Sets HTTP response code.
     * Returns the current object.
     *
     * @param int   $httpCode   HTTP response code.
     *
     * @return Response
     */
    public function setHttpCode($httpCode);

    /**
     * Returns HTTP response code.
     *
     * @return int
     */
    public function getHttpCode();

    /**
     * Sets request execution time.
     * Returns the current object.
     *
     * @param float     $runtime    Request execution time.
     *
     * @return Response
     */
    public function setRuntime($runtime);

    /**
     * Returns request execution time.
     *
     * @return float
     */
    public function getRuntime();

    /**
     * Sets the headers of the http response.
     * Returns the current object.
     *
     * @param HeaderList    $headerList     Headers of the http response.
     *
     * @return Response
     */
    public function setHttpHeaderList(HeaderList $headerList);

    /**
     * Returns the headers of the http response.
     *
     * @return HeaderList
     */
    public function getHttpHeaderList();

    /**
     * Sets the cookies of the http response.
     * Returns the current object.
     *
     * @param CookieList    $cookieList     Cookies of the http response.
     *
     * @return Response
     */
    public function setHttpCookieList(CookieList $cookieList);

    /**
     * Returns the cookies of the http response.
     *
     * @return CookieList
     */
    public function getHttpCookieList();
}
