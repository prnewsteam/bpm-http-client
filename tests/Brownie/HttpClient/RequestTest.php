<?php

namespace Test\Brownie\HttpClient;

use Brownie\HttpClient\Request;
use Prophecy\Prophecy\MethodProphecy;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Request
     */
    protected $request;

    protected function setUp()
    {
        $this->request = new Request();
    }

    protected function tearDown()
    {
        $this->request = null;
    }

    public function testMethod()
    {
        $this->request->setMethod(Request::HTTP_METHOD_DELETE);
        $this->assertEquals(Request::HTTP_METHOD_DELETE, $this->request->getMethod());
    }

    public function testUrl()
    {
        $url = 'http://localhost';
        $this->request->setUrl($url);
        $this->assertEquals($url, $this->request->getUrl());
    }

    public function testBody()
    {
        $body = '{body}';
        $this->request->setBody($body);
        $this->assertEquals($body, $this->request->getBody());
    }

    public function testParams()
    {
        $this->request->addParam('Test', 'Simple');
        $this->assertEquals(array(
            'Test' => 'Simple'
        ), $this->request->getParams());
    }

    public function testBodyFormat()
    {
        $format = 'xml';
        $this->request->setBodyFormat($format);
        $this->assertEquals($format, $this->request->getBodyFormat());
    }

    public function testTimeOut()
    {
        $timeOut = 10;
        $this->request->setTimeOut($timeOut);
        $this->assertEquals($timeOut, $this->request->getTimeOut());
    }

    public function testHeader()
    {
        $header1 = $this->prophesize('Brownie\HttpClient\Header\Header');
        $methodHeader1ToString = new MethodProphecy(
            $header1,
            'toString',
            array()
        );
        $methodHeader1GetName = new MethodProphecy(
            $header1,
            'getName',
            array()
        );
        $methodHeader1GetValue = new MethodProphecy(
            $header1,
            'getValue',
            array()
        );
        $header1
            ->addMethodProphecy(
                $methodHeader1ToString->willReturn('test: Simple')
            );
        $header1
            ->addMethodProphecy(
                $methodHeader1GetName->willReturn('test')
            );
        $header1
            ->addMethodProphecy(
                $methodHeader1GetValue->willReturn('Simple')
            );

        $header1 = $header1->reveal();

        $this->request->addHeader($header1);
        $this->assertEquals(array(
            'test' => $header1
        ), $this->request->getHeaders());
    }

    public function testValidateOk()
    {
        $url = 'http://localhost';
        $this->request->setUrl($url);
        $void = $this->request->validate();
        $this->assertEquals($url, $this->request->getUrl());
        $this->assertNull($void);
    }

    /**
     * @expectedException \Brownie\HttpClient\Exception\ValidateException
     */
    public function testValidateError()
    {
        $this->request->validate();
    }

    public function testDisableSSLValidation()
    {
        $this->assertFalse($this->request->isDisableSSLValidation());
        $this->request->disableSSLValidation();
        $this->assertTrue($this->request->isDisableSSLValidation());
    }

    public function testAuthentication()
    {
        $login = 'tester';
        $password = '123';
        $this->request->setAuthentication($login, $password);
        $this->assertEquals($login . ':' . $password, $this->request->getAuthentication());
    }

    public function testAddCookie()
    {
        $cookie1 = $this->prophesize('Brownie\HttpClient\Cookie\Cookie');
        $methodCookie1ToString = new MethodProphecy(
            $cookie1,
            'toString',
            array()
        );
        $methodCookie1GetName = new MethodProphecy(
            $cookie1,
            'getName',
            array()
        );
        $methodCookie1GetValue = new MethodProphecy(
            $cookie1,
            'getValue',
            array()
        );

        $name = 'cookieTest';
        $value = 'cookieSimple';

        $cookie1
            ->addMethodProphecy(
                $methodCookie1ToString->willReturn($name . '=' . $value)
            );
        $cookie1
            ->addMethodProphecy(
                $methodCookie1GetName->willReturn($name)
            );
        $cookie1
            ->addMethodProphecy(
                $methodCookie1GetValue->willReturn($value)
            );

        $cookie1 = $cookie1->reveal();

        $this
            ->request
            ->addCookie($cookie1);

        $cookies = $this
            ->request
            ->getCookies();

        $this->assertEquals($name, $cookies['cookieTest']->getName());
        $this->assertEquals($value, $cookies['cookieTest']->getValue());
        $this->assertEquals($name . '=' . $value, $cookies['cookieTest']->toString());
    }
}
