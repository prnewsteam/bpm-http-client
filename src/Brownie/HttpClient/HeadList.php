<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient;

use Brownie\Util\StorageList;

/**
 * A wrapper for common lists of HTTP Headers.
 */
class HeadList extends StorageList
{

    /**
     * Returns the SetCookie flag of the HTTP header.
     *
     * @param string    $headerLine     HTTP header line.
     *
     * @return bool
     */
    protected function isHeaderSetCookie($headerLine)
    {
        return ('Set-Cookie:' == substr($headerLine, 0, 11));
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
        return ('HTTP/' == substr($headerLine, 0, 5));
    }
}
