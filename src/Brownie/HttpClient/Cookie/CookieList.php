<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient\Cookie;

use Brownie\HttpClient\HeadList;

class CookieList extends HeadList
{

    /**
     * Initializing the cookies container.
     */
    protected function initList()
    {
        $cookieList = array();
        foreach (explode("\r\n", trim($this->getInitData())) as $headerLine) {
            if (empty($headerLine)) {
                $cookieList = array();
                continue;
            }
            if (!$this->isHeaderSetCookie($headerLine)) {
                continue;
            }
            $cookieParams = $this->getCookieParams($headerLine);
            $cookieList[$cookieParams['name']] = new Cookie($cookieParams);
        }
        $this->setList($cookieList);
    }

    /**
     * Splits HTTP header on the parameters.
     *
     * @param string    $headerLine     HTTP header line Set-Cookie.
     *
     * @return array
     */
    private function getCookieParams($headerLine)
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
