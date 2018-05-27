<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\HttpClient\Client;

/**
 * API CURL functions.
 */
class CurlAdaptee
{

    /**
     * Initialize a cURL session.
     * Returns a cURL handle on success, FALSE on errors.
     *
     * @param string    $url    URL.
     *
     * @return resource
     */
    public function init($url)
    {
        return curl_init($url);
    }

    /**
     * Set an option for a cURL transfer.
     * Returns the current object.
     *
     * @param resource  $curl           A cURL handle.
     * @param int       $option         The CURLOPT_XXX option to set.
     * @param mixed     $value          The value to be set on option.
     *
     * @return self
     */
    public function setopt($curl, $option, $value)
    {
        curl_setopt($curl, $option, $value);
        return $this;
    }

    /**
     * Perform a cURL session.
     * Returns TRUE on success or FALSE on failure. However,
     * if the CURLOPT_RETURNTRANSFER option is set, it will
     * return the result on success, FALSE on failure.
     *
     * @param resource  $curl           A cURL handle.
     *
     * @return mixed
     */
    public function exec($curl)
    {
        return curl_exec($curl);
    }

    /**
     * Get information regarding a specific transfer.
     * If opt is given, returns its value. Otherwise, returns an associative array
     * with the following elements (which correspond to opt), or FALSE on failure.
     *
     * @param resource  $curl           A cURL handle.
     * @param int       $opt            CURLINFO constant.
     *
     * @return mixed
     */
    public function getinfo($curl, $opt)
    {
        return curl_getinfo($curl, $opt);
    }

    /**
     * Return the last error number.
     *
     * @param resource  $curl           A cURL handle.
     *
     * @return int
     */
    public function errno($curl)
    {
        return curl_errno($curl);
    }

    /**
     * Return a string containing the last error for the current session.
     *
     * @param resource  $curl           A cURL handle.
     *
     * @return string
     */
    public function error($curl)
    {
        return curl_error($curl);
    }

    /**
     * Close a cURL session.
     * Returns the current object.
     *
     * @param resource  $curl           A cURL handle.
     *
     * @return self
     */
    public function close($curl)
    {
        curl_close($curl);
        return $this;
    }

    /**
     * Returns user agent string.
     *
     * @return string
     */
    public function getAgentString()
    {
        $info = curl_version();
        return 'PHP Curl ' . $info['version'] . ', SSL: ' . $info['ssl_version'];
    }
}
