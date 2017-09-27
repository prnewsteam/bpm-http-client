<?php

use Brownie\HttpClient\Request;

class RequestTest extends PHPUnit_Framework_TestCase
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
        $this->request->addHeader('Test', 'Simple');
        $this->assertEquals(array(
            'Test' => 'Simple'
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
}
