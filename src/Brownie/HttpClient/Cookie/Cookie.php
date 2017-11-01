<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient\Cookie;

use Brownie\Util\StorageArray;

/**
 * HTTP Cookie class.
 *
 * @method Cookie   setName(string $name)           Sets the name of the cookie.
 * @method string   getName()                       Returns cookie name.
 * @method Cookie   setValue(string $value)         Sets the value of the cookie.
 * @method string   getValue()                      Returns cookie value.
 * @method Cookie   setExpires(string $expires)     Sets time the cookie expires.
 * @method string   getExpires()                    Returns time the cookie expires.
 * @method Cookie   setPath(string $path)           Sets path on the server in which the cookie will be available on.
 * @method string   getPath()                       Returns path on the server in which the cookie will be available on.
 * @method Cookie   setDomain(string $domain)       Sets [sub]domain that the cookie is available to.
 * @method string   getDomain()                     Returns [sub]domain that the cookie is available to.
 * @method Cookie   setSecure(bool $secure)         Indicates that the cookie should only be transmitted over
 *                                                  a secure HTTPS connection from the client.
 * @method bool     getSecure()                     Returns the flag for sending cookies through a
 *                                                  secure HTTPS connection.
 * @method Cookie   setHttponly(bool $httpOnly)     When TRUE the cookie will be made accessible only
 *                                                  through the HTTP protocol.
 * @method bool     getHttponly()                   Returns the cookie availability flag via the HTTP protocol.
 */
class Cookie extends StorageArray
{

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = array(
        'name' => null,         // The name of the cookie.
        'value' => null,        // The value of the cookie.
        'expires' => '',         // The time the cookie expires.
        'path' => '',           // The path on the server in which the cookie will be available on.
        'domain' => '',         // The (sub)domain that the cookie is available to.
        'secure' => false,      // Indicates that the cookie should only be transmitted over
                                // a secure HTTPS connection from the client.
        'httponly' => false,    // When TRUE the cookie will be made accessible only through the HTTP protocol.
    );

    /**
     * Get the value as a string.
     *
     * @return null|string
     */
    public function toString()
    {
        return $this->getName() . '=' . $this->getValue();
    }
}
