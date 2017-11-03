<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient\Header;

use Brownie\HttpClient\HeadList;

/**
 * HTTP headers collection.
 */
class HeaderList extends HeadList
{

    /**
     * Initializing the headers container.
     */
    protected function initList()
    {
        $headerList = array();
        foreach (explode("\r\n", trim($this->getInitData())) as $headerLine) {
            if (empty($headerLine)) {
                $headerList = array();
                continue;
            }
            if ($this->isHeaderHTTP($headerLine) || $this->isHeaderSetCookie($headerLine)) {
                continue;
            }
            $headerParams = $this->getHeaderParams($headerLine);
            $headerList[strtolower($headerParams['name'])] = new Header($headerParams);
        }
        $this->setList($headerList);
    }

    /**
     * Splits Cookie HTTP header on the parameters.
     *
     * @param string    $headerLine     HTTP header line.
     *
     * @return array
     */
    private function getHeaderParams($headerLine)
    {
        $pairParam = explode(':', trim($headerLine), 2);
        $name = trim($pairParam[0]);
        $value = trim($pairParam[1]);
        return array(
            'name' => $name,
            'value' => $value
        );
    }
}
