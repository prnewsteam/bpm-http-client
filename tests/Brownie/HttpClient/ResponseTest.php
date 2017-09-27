<?php

use Brownie\HttpClient\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Response
     */
    protected $response;

    protected function setUp()
    {
        $this->response = new Response();
    }

    protected function tearDown()
    {
        $this->response = null;
    }

    public function testBody()
    {
        $body = '{body}';
        $this->response->setBody($body);
        $this->assertEquals($body, $this->response->getBody());
    }

    public function testHttpCode()
    {
        $httpCode = 500;
        $this->response->setHttpCode($httpCode);
        $this->assertEquals($httpCode, $this->response->getHttpCode());
    }

    public function testRuntime()
    {
        $runtime = 2.2;
        $this->response->setRuntime($runtime);
        $this->assertEquals($runtime, $this->response->getRuntime());
    }
}
