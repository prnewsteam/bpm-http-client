<?php

namespace Test\Brownie\HttpClient;

use Brownie\HttpClient\HttpClient;
use Brownie\HttpClient\Request;
use Prophecy\Prophecy\MethodProphecy;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var HTTPClient
     */
    protected $httpClient;

    protected $curlAdapter;

    protected function setUp()
    {
        $this->curlAdapter = $this
            ->prophesize('Brownie\HttpClient\Client\CurlAdapter');

        $this->httpClient = new HttpClient($this->curlAdapter->reveal());
    }

    protected function tearDown()
    {
        $this->httpClient = null;
    }

    public function testRequest()
    {
        $request = $this->createRequest('http://localhost/endpoint');

        $methodHttpRequest = new MethodProphecy(
            $this->curlAdapter,
            'httpRequest',
            array($request)
        );

        $response = $this->createResponse('Simple text', 200, 5.5);

        $this->curlAdapter
            ->addMethodProphecy(
                $methodHttpRequest->willReturn($response)
            );

        $response = $this->httpClient->request($request);

        $this->assertEquals('Simple text', $response->getBody());
        $this->assertEquals(200, $response->getHttpCode());
        $this->assertEquals(5.5, $response->getRuntime());
    }

    private function createResponse($body, $httpCode, $runtime)
    {
        $response = $this
            ->prophesize('Brownie\HttpClient\Response');

        $methodGetBody = new MethodProphecy(
            $response,
            'getBody',
            array()
        );
        $response
            ->addMethodProphecy(
                $methodGetBody->willReturn($body)
            );

        $methodGetHttpCode = new MethodProphecy(
            $response,
            'getHttpCode',
            array()
        );
        $response
            ->addMethodProphecy(
                $methodGetHttpCode->willReturn($httpCode)
            );

        $methodGetRuntime = new MethodProphecy(
            $response,
            'getRuntime',
            array()
        );
        $response
            ->addMethodProphecy(
                $methodGetRuntime->willReturn($runtime)
            );

        return $response->reveal();
    }

    private function createRequest($url)
    {
        $request = $this
            ->prophesize('Brownie\HttpClient\Request');

        $methodGetMethod = new MethodProphecy(
            $request,
            'getMethod',
            array()
        );

        $methodGetUrl = new MethodProphecy(
            $request,
            'getUrl',
            array()
        );

        $methodGetBody = new MethodProphecy(
            $request,
            'getBody',
            array()
        );

        $methodGetParams = new MethodProphecy(
            $request,
            'getParams',
            array()
        );

        $methodGetBodyFormat = new MethodProphecy(
            $request,
            'getBodyFormat',
            array()
        );

        $methodGetTimeOut = new MethodProphecy(
            $request,
            'getTimeOut',
            array()
        );

        $methodGetHeaders = new MethodProphecy(
            $request,
            'getHeaders',
            array()
        );

        $methodValidate = new MethodProphecy(
            $request,
            'validate',
            array()
        );

        $methodGetAuthentication = new MethodProphecy(
            $request,
            'getAuthentication',
            array()
        );

        $request
            ->addMethodProphecy(
                $methodGetMethod->willReturn('PUT')
            );

        $request
            ->addMethodProphecy(
                $methodGetUrl->willReturn($url)
            );

        $request
            ->addMethodProphecy(
                $methodGetBody->willReturn('{"Hello":"World"}')
            );

        $request
            ->addMethodProphecy(
                $methodGetParams->willReturn(array(
                    'page' => 5555
                ))
            );

        $request
            ->addMethodProphecy(
                $methodGetBodyFormat->willReturn(Request::FORMAT_APPLICATION_JSON)
            );

        $request
            ->addMethodProphecy(
                $methodGetTimeOut->willReturn(100)
            );

        $request
            ->addMethodProphecy(
                $methodGetHeaders->willReturn(array())
            );

        $request
            ->addMethodProphecy(
                $methodValidate->willReturn(null)
            );

        $request
            ->addMethodProphecy(
                $methodGetAuthentication->willReturn('tester:123')
            );

        return $request->reveal();
    }

    public function testCreateRequest()
    {
        $this->assertInstanceOf('\Brownie\HttpClient\Request', $this->httpClient->createRequest());
    }

    public function testCreateCookie()
    {
        $cookie = $this->httpClient->createCookie('testName', 'testValue');
        $this->assertInstanceOf('\Brownie\HttpClient\Cookie\Cookie', $cookie);
        $this->assertEquals('testName', $cookie->getName());
        $this->assertEquals('testValue', $cookie->getValue());
    }

    public function testCreateHeader()
    {
        $header = $this->httpClient->createHeader('testName', 'testValue');
        $this->assertInstanceOf('\Brownie\HttpClient\Header\Header', $header);
        $this->assertEquals('testName', $header->getName());
        $this->assertEquals('testValue', $header->getValue());
    }
}
