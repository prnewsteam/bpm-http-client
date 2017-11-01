<?php

namespace Test\Brownie\HttpClient\Header;

use Brownie\HttpClient\Header\HeaderList;

class HeaderListTest extends \PHPUnit_Framework_TestCase
{

    public function testToArray1()
    {
        $headerList = new HeaderList('TestHeaderName: TestHeaderValue');
        $headers = $headerList->toArray();
        $header = $headers['testheadername'];
        $this->assertEquals('TestHeaderName', $header->getName());
        $this->assertEquals('TestHeaderValue', $header->getValue());
    }

    public function testToArray2()
    {
        $headerList = new HeaderList('TestHeaderName: TestHeaderValue' . "\r\n\r\n" . 'TestHeaderName2: TestHeaderValue2');
        $headers = $headerList->toArray();
        $header = $headers['testheadername2'];
        $this->assertEquals('TestHeaderName2', $header->getName());
        $this->assertEquals('TestHeaderValue2', $header->getValue());
    }

    public function testToArray3()
    {
        $headerList = new HeaderList('TestHeaderName: TestHeaderValue' . "\r\n" . 'HTTP/1.1 200 Ok');
        $headers = $headerList->toArray();
        $header = $headers['testheadername'];
        $this->assertEquals('TestHeaderName', $header->getName());
        $this->assertEquals('TestHeaderValue', $header->getValue());
    }
}
