<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient\Cookie;

use Brownie\HttpClient\HeadList;

/**
 * HTTP cookie collection.
 */
class CookieList extends HeadList
{

    /**
     * Returns the HTTP header skip flag.
     *
     * @param string    $headerLine     HTTP header line.
     *
     * @return bool
     */
    protected function isSkipHeaderLine($headerLine)
    {
        return !$this->isHeaderSetCookie($headerLine);
    }

    /**
     * Creates a data model for the collection.
     *
     * @param string    $headerLine     HTTP header line.
     *
     * @return Cookie
     */
    public function createCollectionItem($headerLine)
    {
        return new Cookie($this->getParams($headerLine));
    }

    /**
     * Returns HTTP header parameters.
     *
     * @param string    $headerLine     HTTP header line.
     *
     * @return array
     */
    private function getParams($headerLine)
    {
        $cookieParamsStrings = explode(':', trim($headerLine), 2);
        $params = array();
        foreach (explode(';', trim($cookieParamsStrings[1])) as $index => $paramString) {
            $pairParam = explode('=', trim($paramString), 2);
            $name = trim($pairParam[0]);
            $value = (!empty($pairParam[1]) ? trim($pairParam[1]) : true);
            if (0 == $index) {
                $params['name'] = $name;
                $params['value'] = $value;
                continue;
            }
            $params[$name] = $value;
        }
        return $params;
    }
}
