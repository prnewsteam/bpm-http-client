<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient\Header;

use Brownie\Util\StorageList;

/**
 * HTTP headers collection.
 */
class HeaderList extends StorageList
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
            if (
                ('HTTP/' == substr($headerLine, 0, 5)) ||
                ('Set-Cookie:' == substr($headerLine, 0, 11))
            ) {
                continue;
            }
            $headerParams = explode(':', trim($headerLine), 2);
            $key = trim($headerParams[0]);
            $headerList[strtolower($key)] = new Header(array(
                'name' => $key,
                'value' => trim($headerParams[1])
            ));
        }
        $this->setList($headerList);
    }
}
