<?php

namespace Test\Brownie\HttpClient;

use Brownie\HttpClient\Response;
use Prophecy\Prophecy\MethodProphecy;

class ResponseTest extends \PHPUnit_Framework_TestCase
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

    public function testGetHttpHeaderList()
    {
        $headerList = $this->prophesize('Brownie\HttpClient\Header\HeaderList');
        $methodToArray = new MethodProphecy(
            $headerList,
            'toArray',
            array()
        );

        $toArray = array('test' => 'ok');

        $headerList
            ->addMethodProphecy(
                $methodToArray->willReturn($toArray)
            );

        $this->response->setHttpHeaderList($headerList->reveal());
        $headers = $this->response->getHttpHeaderList();

        $this->assertEquals($toArray, $headers->toArray());
    }

    public function testGetHttpCookieList()
    {
        $cookieList = $this->prophesize('Brownie\HttpClient\Cookie\CookieList');
        $methodToArray = new MethodProphecy(
            $cookieList,
            'toArray',
            array()
        );

        $toArray = array('test' => 'ok');

        $cookieList
            ->addMethodProphecy(
                $methodToArray->willReturn($toArray)
            );

        $this->response->setHttpCookieList($cookieList->reveal());
        $cookies = $this->response->getHttpCookieList();

        $this->assertEquals($toArray, $cookies->toArray());
    }
}
