<?php
/**
 * @category    Brownie/HttpClient
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\HttpClient\Client;

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

        $this->getAdaptee()->close($curl);

        $response = new Response();
        return $response
            ->setBody($responseBody)
            ->setHttpCode($httpCode)
            ->setRuntime($runtime);
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
        $url = $request->getUrl();

        /**
         * Adds GET parameters.
         */
        $params = $request->getParams();
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        /**
         * Initializing CURL.
         */
        $curl = $this->getAdaptee()->init($url);

        /**
         * Sets the request body.
         */
        $body = $request->getBody();
        if (!empty($body)) {
            $this->getAdaptee()->setopt($curl, CURLOPT_POSTFIELDS, $body);

        }

        /**
         * CURL setting.
         */
        $this
            ->getAdaptee()
            ->setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getMethod())
            ->setopt($curl, CURLOPT_TIMEOUT, $request->getTimeOut())
            ->setopt($curl, CURLOPT_NOPROGRESS, true)
            ->setopt($curl, CURLOPT_RETURNTRANSFER, true)
            ->setopt($curl, CURLOPT_URL, $url);

        if ($request->isDisableSSLValidation()) {
            /**
             * Disable SSL validation.
             */
            $this
                ->getAdaptee()
                ->setopt($curl, CURLOPT_SSL_VERIFYPEER, false)
                ->setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }

        /**
         * Configuring HTTP headers.
         */
        $headers = array(
            'Connection: close',
            'Accept-Ranges: bytes',
            'Content-Length: ' . strlen($body),
            'Accept: ' . $request->getBodyFormat(),
            'Content-Type: ' . $request->getBodyFormat() . '; charset=utf-8',
            'User-Agent: ' . $this->getAdaptee()->getAgentString(),
        );
        foreach ($request->getHeaders() as $name => $value) {
            $headers[] = $name . ': ' . $value;
        }
        $this->getAdaptee()->setopt($curl, CURLOPT_HTTPHEADER, $headers);

        return $curl;
    }
}
