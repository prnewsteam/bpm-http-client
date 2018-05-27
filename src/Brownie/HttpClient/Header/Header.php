<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\HttpClient\Header;

use Brownie\Util\StorageArray;

/**
 * HTTP Header class.
 *
 * @method  Header      setName(string $name)       Sets the name of the header.
 * @method  string      getName()                   Returns header name.
 * @method  Header      setValue(string $value)     Sets the value of the header.
 * @method  string      getValue()                  Returns header value.
 */
class Header extends StorageArray
{

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = array(
        'name' => null,     // Header name.
        'value' => null,    // Header value.
    );

    /**
     * Get the value as a string.
     *
     * @return null|string
     */
    public function toString()
    {
        $name = $this->getName();
        $value = $this->getValue();
        if (!empty($name) && !empty($value)) {
            return $name . ': ' . $value;
        }
        return null;
    }
}
