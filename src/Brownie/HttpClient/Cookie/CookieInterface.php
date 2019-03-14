<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\HttpClient\Cookie;

interface CookieInterface
{

    /**
     * Sets the name of the cookie.
     * Returns the current object.
     *
     * @param string    $name   Name of the cookie.
     *
     * @return Cookie
     */
    public function setName($name);

    /**
     * Returns cookie name.
     *
     * @return string
     */
    public function getName();

    /**
     * Sets the value of the cookie.
     * Returns the current object.
     *
     * @param string    $value      Value of the cookie.
     *
     * @return Cookie
     */
    public function setValue($value);

    /**
     * Returns cookie value.
     *
     * @return string
     */
    public function getValue();

    /**
     * Sets time the cookie expires.
     * Returns the current object.
     *
     * @param string    $expires    Time the cookie expires.
     *
     * @return Cookie
     */
    public function setExpires($expires);

    /**
     * Returns time the cookie expires.
     *
     * @return string
     */
    public function getExpires();

    /**
     * Sets path on the server in which the cookie will be available on.
     * Returns the current object.
     *
     * @param string    $path   Path on the server in which the cookie will be available on.
     *
     * @return Cookie
     */
    public function setPath($path);

    /**
     * Returns path on the server in which the cookie will be available on.
     *
     * @return string
     */
    public function getPath();

    /**
     * Sets [sub]domain that the cookie is available to.
     * Returns the current object.
     *
     * @param string    $domain     Domain that the cookie is available to.
     *
     * @return Cookie
     */
    public function setDomain($domain);

    /**
     * Returns [sub]domain that the cookie is available to.
     *
     * @return string
     */
    public function getDomain();

    /**
     * Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client.
     * Returns the current object.
     *
     * @param bool  $secure     Secure HTTPS connection from the client.
     *
     * @return Cookie
     */
    public function setSecure($secure);

    /**
     * Returns the flag for sending cookies through a secure HTTPS connection.
     *
     * @return bool
     */
    public function getSecure();

    /**
     * When TRUE the cookie will be made accessible only through the HTTP protocol.
     * Returns the current object.
     *
     * @param bool  $httpOnly   Cookie availability flag via the HTTP protocol.
     *
     * @return Cookie
     */
    public function setHttponly($httpOnly);

    /**
     * Returns the cookie availability flag via the HTTP protocol.
     *
     * @return bool
     */
    public function getHttponly();
}
