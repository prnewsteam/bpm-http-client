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
     * Returns the HTTP header skip flag.
     *
     * @param string    $headerLine     HTTP header line.
     *
     * @return bool
     */
    protected function isSkipHeaderLine($headerLine)
    {
        return ($this->isHeaderHTTP($headerLine) || $this->isHeaderSetCookie($headerLine));
    }

    /**
     * Creates a data model for the collection.
     *
     * @param string    $headerLine     HTTP header line.
     *
     * @return Header
     */
    public function createCollectionItem($headerLine)
    {
        return new Header($this->getParams($headerLine));
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
        $pairParam = explode(':', trim($headerLine), 2);
        return array(
            'name' => trim($pairParam[0]),
            'value' => trim($pairParam[1])
        );
    }
}
