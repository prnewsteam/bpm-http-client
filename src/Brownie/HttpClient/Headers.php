<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient;

/**
 * HTTP headers collection.
 */
class Headers
{

    /**
     * All headers at once.
     *
     * @var null|string
     */
    private $headerString = null;

    /**
     * Headers container as an array.
     *
     * @var null|array
     */
    private $headerList = null;

    /**
     * Sets incoming values.
     *
     * @param $headerString
     */
    public function __construct($headerString)
    {
        $this->setHeaderString(trim($headerString));
    }

    /**
     * Sets all headers at string.
     * Returns the current object.
     *
     * @param string    $headerString   All headers at string.
     *
     * @return self
     */
    private function setHeaderString($headerString)
    {
        $this->headerString = $headerString;
        return $this;
    }

    /**
     * Returns all headers at string.
     *
     * @return null|string
     */
    public function toString()
    {
        return $this->headerString;
    }

    /**
     * Sets headers container.
     * Returns the current object.
     *
     * @param array     $headerList     Headers container as an array.
     *
     * @return self
     */
    private function setHeaderList(array $headerList)
    {
        $this->headerList = $headerList;
        return $this;
    }

    /**
     * Return the headers container as an array.
     *
     * @return array|null
     */
    public function getHeaderList()
    {
        if (empty($this->headerList)) {
            $this->setHeaderList($this->initHeaderList());
        }
        return $this->headerList;
    }

    /**
     * Gets header of by name.
     *
     * @param string    $name               Header name.
     * @param mixed     $defaultValue       Default header value.
     *
     * @return string|mixed
     */
    public function get($name, $defaultValue = null)
    {
        $headerList = $this->getHeaderList();
        $name = strtolower($name);
        if (empty($headerList[$name])) {
            return $defaultValue;
        }
        return $headerList[$name];
    }

    /**
     * Initializing the headers container.
     * Returns headers container.
     *
     * @return array
     */
    private function initHeaderList()
    {
        $headerList = array();
        foreach (explode("\r\n", $this->toString()) as $index => $headerLine) {
            if (0 == $index) {
                continue;
            }
            list($key, $value) = explode(':', trim($headerLine), 2);
            $headerList[strtolower(trim($key))] = trim($value);
        }
        $this->setHeaderList($headerList);
        return $headerList;
    }
}
