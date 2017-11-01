<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient\Cookie;

use Brownie\Util\StorageList;

class CookieList extends StorageList
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
            if ('Set-Cookie:' != substr($headerLine, 0, 11)) {
                continue;
            }
            $cookieParams = explode(':', trim($headerLine), 2);
            $params = $cookieParams[1];

            $cookieParams = array();
            foreach (explode(';', trim($params)) as $index => $param) {
                $param = trim($param);
                $params = explode('=', $param, 2);
                $name = trim($params[0]);
                if (!empty($params[1])) {
                    $value = trim($params[1]);
                }
                if (0 == $index) {
                    $cookieParams['name'] = $name;
                    $cookieParams['value'] = $value;
                    continue;
                }
                switch ($name) {
                    case 'expires':
                    case 'path':
                    case 'domain':
                        $cookieParams[$name] = $value;
                        break;
                    case 'secure':
                    case 'httponly':
                        $cookieParams[$name] = true;
                        break;
                }
            }
            $cookieList[$cookieParams['name']] = new Cookie($cookieParams);
        }

        $this->setList($cookieList);
    }
}
