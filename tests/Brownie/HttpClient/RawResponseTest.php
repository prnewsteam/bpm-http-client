<?php

namespace Test\Brownie\HttpClient;

use Brownie\HttpClient\RawResponse;

class RawResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var RawResponse
     */
    protected $rawResponse;

    protected function setUp()
    {
        $this->rawResponse = new RawResponse();
    }

    protected function tearDown()
    {
        $this->rawResponse = null;
    }

    public function testSetGetRuntime()
    {
        $runtime = 5.7;
        $this->rawResponse->setRuntime($runtime);
        $this->assertEquals($runtime, $this->rawResponse->getRuntime());
    }

    public function testSetGetHttpCode()
    {
        $httpCode = 999;
        $this->rawResponse->setHttpCode($httpCode);
        $this->assertEquals($httpCode, $this->rawResponse->getHttpCode());
    }

    public function testSetGetHeaderSize()
    {
        $headerSize = 100;
        $this->rawResponse->setHeaderSize($headerSize);
        $this->assertEquals($headerSize, $this->rawResponse->getHeaderSize());
    }

    public function testSetGetResponseBody()
    {
        $responseBody = '{"test":"simple"}';
        $this->rawResponse->setResponseBody($responseBody);
        $this->assertEquals($responseBody, $this->rawResponse->getResponseBody());
    }
}
