<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\HttpClient\Client;

use Brownie\HttpClient\Cookie\CookieList;
use Brownie\HttpClient\Header\HeaderList;
use Brownie\HttpClient\RawResponse;
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
        $rawResponse = $this->request($request);
        /**
         * Gets the HTTP headers and the body separately.
         */
        $body = substr($rawResponse->getResponseBody(), $rawResponse->getHeaderSize());
        if (empty($body)) {
            $body = '';
        }
        $httpHeadersString = substr($rawResponse->getResponseBody(), 0, $rawResponse->getHeaderSize());

        $response = new Response();
        return $response
            ->setBody($body)
            ->setHttpCode($rawResponse->getHttpCode())
            ->setRuntime($rawResponse->getRuntime())
            ->setHttpHeaderList(new HeaderList($httpHeadersString))
            ->setHttpCookieList(new CookieList($httpHeadersString));
    }

    /**
     * Executes a network resource request.
     *
     * @param Request       $request    HTTP request params.
     *
     * @return RawResponse
     */
    private function request(Request $request)
    {
        $this->initParams($request);

        $curl = $this->getCurlClient($request);
        $responseBody = $this->curlExec($curl);

        $runtime = $this->getAdaptee()->getinfo($curl, CURLINFO_TOTAL_TIME);
        $httpCode = $this->getAdaptee()->getinfo($curl, CURLINFO_HTTP_CODE);
        $headerSize = $this->getAdaptee()->getinfo($curl, CURLINFO_HEADER_SIZE);

        $this->getAdaptee()->close($curl);

        return new RawResponse(
            array(
                'runtime' => $runtime,
                'httpCode' => $httpCode,
                'headerSize' => $headerSize,
                'responseBody' => $responseBody
            )
        );
    }

    /**
     * Perform a request session.
     * Returns the body of the response
     *
     * @param resource      $curl       Curl client.
     *
     * @return string
     *
     * @throws ClientException
     */
    private function curlExec($curl)
    {
        $responseBody = $this->getAdaptee()->exec($curl);
        if ((0 != $this->getAdaptee()->errno($curl)) || !is_string($responseBody)) {
            throw new ClientException($this->getAdaptee()->error($curl));
        }
        return $responseBody;
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
        $curl = $this->getAdaptee()->init($request->getUrl());
        $this->setBaseOpt($curl, $request);
        $this->setHedaers($curl, $request);
        return $curl;
    }

    /**
     * Sets the basic options.
     *
     * @param resource  $curl       CURL resource.
     * @param Request   $request    HTTP request params.
     */
    private function setBaseOpt($curl, Request $request)
    {
        $this->setDefaultOpt($curl, $request);
        $this->triggerEnablePostParams($curl, $request);
        $this->triggerDisableSSLCertificateValidation($curl, $request);
        $this->triggerAuthentication($curl, $request);
        $this
            ->getAdaptee()
            ->setopt($curl, CURLOPT_POSTFIELDS, $request->getBody());
    }

    /**
     * Sets the default values.
     *
     * @param resource  $curl       CURL resource.
     * @param Request   $request    HTTP request params.
     */
    private function setDefaultOpt($curl, Request $request)
    {
        $this
            ->getAdaptee()
            ->setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getMethod())
            ->setopt($curl, CURLOPT_TIMEOUT, $request->getTimeOut())
            ->setopt($curl, CURLOPT_NOPROGRESS, true)
            ->setopt($curl, CURLOPT_RETURNTRANSFER, true)
            ->setopt($curl, CURLOPT_URL, $request->getUrl())
            ->setopt($curl, CURLOPT_HEADER, true);
    }

    /**
     * Configures POST data.
     *
     * @param resource  $curl       CURL resource.
     * @param Request   $request    HTTP request params.
     */
    private function triggerEnablePostParams($curl, Request $request)
    {
        if ($this->isPostOrPutRequest($request)) {
            $this
                ->getAdaptee()
                ->setopt($curl, CURLOPT_POST, true);
        }
    }

    /**
     * Returns the POST or PUT request flag.
     *
     * @param Request   $request    HTTP request params.
     *
     * @return bool
     */
    private function isPostOrPutRequest(Request $request)
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
     * @param resource  $curl       CURL resource.
     * @param Request   $request    HTTP request params.
     */
    private function setHedaers($curl, Request $request)
    {
        /**
         * Sets HTTP headers.
         */
        $headers = $this->createBaseHeaderList($request);
        if (!$this->isPostOrPutRequest($request)) {
            $headers[] = 'Content-Type: ' . $request->getBodyFormat() . '; charset=utf-8';
        }
        $headers = array_merge($headers, $this->createCustomHeaderList($request));
        $headers = array_merge($headers, $this->createCookieHeaderList($request));

        $this->getAdaptee()->setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }

    /**
     * Returns the basic set of HTTP headers.
     *
     * @param Request   $request    HTTP request params.
     *
     * @return array
     */
    private function createBaseHeaderList(Request $request)
    {
        return array(
            'Connection: close',
            'Accept-Ranges: bytes',
            'Content-Length: ' . strlen($request->getBody()),
            'Accept: ' . $request->getBodyFormat() . ',*/*',
            'User-Agent: ' . $this->getAdaptee()->getAgentString(),
        );
    }

    /**
     * Returns a custom set of HTTP headers.
     *
     * @param Request   $request    HTTP request params.
     *
     * @return array
     */
    private function createCustomHeaderList(Request $request)
    {
        $headers = array();
        foreach ($request->getHeaders() as $header) {
            $headers[] = $header->toString();
        }
        return $headers;
    }

    /**
     * Returns the HTTP cookies for the HTTP header.
     *
     * @param Request   $request    HTTP request params.
     *
     * @return array
     */
    private function createCookieHeaderList(Request $request)
    {
        $cookies = array();
        foreach ($request->getCookies() as $cookie) {
            $cookies[] = $cookie->toString();
        }
        $headers = array();
        if (!empty($cookies)) {
            $headers[] = 'Cookie: ' . implode('; ', $cookies);
        }
        return $headers;
    }

    /**
     * Initializing query parameters.
     *
     * @param Request   $request    HTTP request params.
     */
    private function initParams(Request $request)
    {
        $params = $request->getParams();
        if (empty($params)) {
            return;
        }
        $paramsURLEncoded = http_build_query($params);
        if ($this->isPostOrPutRequest($request)) {
            /**
             * Adds body parameters.
             */
            $request->setBody($paramsURLEncoded);
        } else {
            /**
             * Adds url parameters.
             */
            $request->setUrl($request->getUrl() . '?' . $paramsURLEncoded);
        }
    }
}
