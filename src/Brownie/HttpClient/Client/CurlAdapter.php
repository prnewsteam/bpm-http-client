<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient\Client;

use Brownie\HttpClient\Cookie\Cookie;
use Brownie\HttpClient\Cookie\CookieList;
use Brownie\HttpClient\Header\Header;
use Brownie\HttpClient\Header\HeaderList;
use Brownie\HttpClient\Request;
use Brownie\HttpClient\Response;
use Brownie\HttpClient\Client;
use Brownie\HttpClient\Exception\ClientException;

/**
 * API(Adapter) for using CURL functions in HTTP requests.
 */
class CurlAdapter implements Client
{

    /**
     * API CURL functions.
     *
     * @var CurlAdaptee
     */
    private $adaptee;

    /**
     * Sets incoming data.
     *
     * @param CurlAdaptee       $adaptee        API CURL functions.
     */
    public function __construct(CurlAdaptee $adaptee)
    {
        $this->setAdaptee($adaptee);
    }

    /**
     * Sets API CURL functions wrapper.
     * Returns the current object.
     *
     * @param CurlAdaptee $adaptee
     *
     * @return self
     */
    private function setAdaptee(CurlAdaptee $adaptee)
    {
        $this->adaptee = $adaptee;
        return $this;
    }

    /**
     * Returns API CURL functions wrapper.
     *
     * @return CurlAdaptee
     */
    private function getAdaptee()
    {
        return $this->adaptee;
    }

    /**
     * Performs a network request.
     * Returns the response.
     *
     * @param Request       $request    HTTP request params.
     *
     * @throws ClientException
     *
     * @return Response
     */
    public function httpRequest(Request $request)
    {
        $curl = $this->getCurlClient($request);

        /**
         * Executes a network resource request.
         */
        $responseBody = $this->getAdaptee()->exec($curl);

        $httpCode = $this->getAdaptee()->getinfo($curl, CURLINFO_HTTP_CODE);

        /**
         * Network error checking.
         */
        if ((0 != $this->getAdaptee()->errno($curl)) || !is_string($responseBody)) {
            throw new ClientException($this->getAdaptee()->error($curl));
        }

        /**
         * Gets the execution time of the request.
         */
        $runtime = $this->getAdaptee()->getinfo($curl, CURLINFO_TOTAL_TIME);

        /**
         * Gets the HTTP headers and the body separately.
         */
        $headerSize = $this->getAdaptee()->getinfo($curl, CURLINFO_HEADER_SIZE);
        $body = substr($responseBody, $headerSize);

        $this->getAdaptee()->close($curl);

        $httpHeadersString = substr($responseBody, 0, $headerSize);

        $response = new Response();
        return $response
            ->setBody($body)
            ->setHttpCode($httpCode)
            ->setRuntime($runtime)
            ->setHttpHeaderList(new HeaderList($httpHeadersString))
            ->setHttpCookieList(new CookieList($httpHeadersString));
    }

    /**
     * Creates and returns a CURL resource.
     *
     * @param Request       $request        HTTP request params.
     *
     * @return resource
     */
    private function getCurlClient(Request $request)
    {

        /**
         * Build URL.
         */
        $url = $this->getUrl($request);

        /**
         * Initializing CURL.
         */
        $curl = $this->getAdaptee()->init($url);

        /**
         * CURL setting.
         */
        $this->setBaseOpt($curl, $request, $url);

        /**
         * Configuring HTTP headers.
         */
        $this->setHedaers($curl, $request);

        return $curl;
    }

    /**
     * Generates and returns URL.
     *
     * @param Request   $request    HTTP request params.
     *
     * @return string
     */
    private function getUrl(Request $request)
    {
        $url = $request->getUrl();

        /**
         * Adds GET parameters.
         */
        $params = $request->getParams();
        if ((Request::HTTP_METHOD_GET == $request->getMethod()) && !empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    /**
     * Sets the basic options.
     *
     * @param resource  $curl       CURL resource.
     * @param Request   $request    HTTP request params.
     * @param string    $url        Request URL.
     */
    private function setBaseOpt($curl, Request $request, $url)
    {
        $this
            ->getAdaptee()
            ->setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getMethod())
            ->setopt($curl, CURLOPT_TIMEOUT, $request->getTimeOut())
            ->setopt($curl, CURLOPT_NOPROGRESS, true)
            ->setopt($curl, CURLOPT_RETURNTRANSFER, true)
            ->setopt($curl, CURLOPT_URL, $url)
            ->setopt($curl, CURLOPT_HEADER, true);

        if ($this->isPostParams($request)) {
            $this
                ->getAdaptee()
                ->setopt($curl, CURLOPT_POST, true);
            $params = $request->getParams();
            if (!empty($params)) {
                $params = http_build_query($params);
                $request->setBody($params);
            }
        }

        $this
            ->getAdaptee()
            ->setopt($curl, CURLOPT_POSTFIELDS, $request->getBody());

        $this->triggerDisableSSLCertificateValidation($curl, $request);

        $this->triggerAuthentication($curl, $request);
    }

    /**
     * Returns the POST character of the data.
     *
     * @param Request   $request    HTTP request params.
     *
     * @return bool
     */
    private function isPostParams(Request $request)
    {
        return (Request::HTTP_METHOD_POST == $request->getMethod()) ||
            (Request::HTTP_METHOD_PUT == $request->getMethod());
    }

    /**
     * Controlling verification of SSL certificates.
     *
     * @param resource  $curl           CURL resource.
     * @param Request   $request        HTTP request params.
     */
    private function triggerDisableSSLCertificateValidation($curl, Request $request)
    {
        if ($request->isDisableSSLValidation()) {
            /**
             * Disable SSL validation.
             */
            $this
                ->getAdaptee()
                ->setopt($curl, CURLOPT_SSL_VERIFYPEER, false)
                ->setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
    }

    /**
     * Controlling request authentication.
     *
     * @param resource  $curl           CURL resource.
     * @param Request   $request        HTTP request params.
     */
    private function triggerAuthentication($curl, Request $request)
    {
        $authentication = $request->getAuthentication();
        if (!empty($authentication)) {
            /**
             * Enable authentication.
             */
            $this
                ->getAdaptee()
                ->setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY)
                ->setopt($curl, CURLOPT_USERPWD, $authentication);
        }
    }

    /**
     * Sets HTTP headers.
     *
     * @param resource  $curl                   CURL resource.
     * @param Request   $request                HTTP request params.
     */
    private function setHedaers($curl, Request $request)
    {
        $headers = array(
            'Connection: close',
            'Accept-Ranges: bytes',
            'Content-Length: ' . strlen($request->getBody()),
            'Accept: ' . $request->getBodyFormat() . ',*/*',
            'User-Agent: ' . $this->getAdaptee()->getAgentString(),
        );

        if (!$this->isPostParams($request)) {
            $headers[] = 'Content-Type: ' . $request->getBodyFormat() . '; charset=utf-8';
        }

        /**
         * @var Header  $header     Header.
         */
        foreach ($request->getHeaders() as $header) {
            $headers[] = $header->toString();
        }
        /**
         * @var Cookie  $cookie     Cookie.
         */
        $cookies = array();
        foreach ($request->getCookies() as $cookie) {
            $cookies[] = $cookie->toString();
        }
        if (!empty($cookies)) {
            $headers[] = 'Cookie: ' . implode('; ', $cookies);
        }
        $this->getAdaptee()->setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }
}
