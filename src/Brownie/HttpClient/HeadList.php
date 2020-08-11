<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\HttpClient;

use Brownie\Util\Exception\MethodNotImplementedException;
use Brownie\Util\StorageList;

/**
 * A wrapper for common lists of HTTP Headers.
 */
class HeadList extends StorageList
{

    /**
     * Initializing container.
     */
    protected function initList()
    {
        $list = array();
        foreach (explode("\r\n", trim($this->getInitData())) as $headerLine) {
            if (empty($headerLine)) {
                $list = array();
                continue;
            }
            if ($this->isSkipHeaderLine($headerLine)) {
                continue;
            }
            $item = $this->createCollectionItem($headerLine);
            $list[strtolower($item->getName())] = $item;
        }
        $this->setList($list);
    }

    /**
     * Returns the SetCookie flag of the HTTP header.
     *
     * @param string    $headerLine     HTTP header line.
     *
     * @return bool
     */
    protected function isHeaderSetCookie($headerLine)
    {
        return ('set-cookie:' == substr(strtolower($headerLine), 0, 11));
    }

    /**
     * Returns the HTTP flag of the header.
     *
     * @param string    $headerLine     HTTP header line.
     *
     * @return bool
     */
    protected function isHeaderHTTP($headerLine)
    {
        return ('http/' == substr(strtolower($headerLine), 0, 5));
    }

    /**
     * Returns the HTTP header skip flag.
     *
     * @param string    $headerLine     HTTP header line.
     *
     * @return bool
     *
     * @throws MethodNotImplementedException
     */
    protected function isSkipHeaderLine($headerLine)
    {
        throw new MethodNotImplementedException('Method not implemented');
    }

    /**
     * Creates a data model for the collection.
     *
     * @param string    $headerLine     HTTP header line.
     *
     * @return mixed
     *
     * @throws MethodNotImplementedException
     */
    public function createCollectionItem($headerLine)
    {
        throw new MethodNotImplementedException('Method not implemented');
    }
}
