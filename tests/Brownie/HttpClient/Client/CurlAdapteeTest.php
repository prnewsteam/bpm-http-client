<?php

namespace Test\Brownie\HttpClient\Client;

use Brownie\HttpClient\Client\CurlAdaptee;

class CurlAdapteeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var CurlAdaptee
     */
    protected $curlAdaptee;

    protected function setUp()
    {
        $this->curlAdaptee = new CurlAdaptee();
    }

    protected function tearDown()
    {
        $this->curlAdaptee = null;
    }

    public function testInit()
    {
        $resource = $this->curlAdaptee->init('https://api.github.com/emojis');
        $this->assertTrue(is_resource($resource));
    }

    public function testSetopt()
    {
        $resource = $this->curlAdaptee->init('');
        $curlAdaptee = $this->curlAdaptee->setopt($resource, CURLOPT_URL, '');
        $this->assertEquals($curlAdaptee, $this->curlAdaptee);
    }

    public function testExec()
    {
        $resource = $this->curlAdaptee->init('');
        $response = $this->curlAdaptee->exec($resource);
        $this->assertFalse($response);
    }

    public function testGetinfo()
    {
        $resource = $this->curlAdaptee->init('');
        $httpCode = $this->curlAdaptee->getinfo($resource, CURLINFO_HTTP_CODE);
        $this->assertEquals(0, $httpCode);
    }

    public function testErrno()
    {
        $resource = $this->curlAdaptee->init('');
        $number = $this->curlAdaptee->errno($resource);
        $this->assertEquals(0, $number);
    }

    public function testError()
    {
        $resource = $this->curlAdaptee->init('');
        $message = $this->curlAdaptee->error($resource);
        $this->assertEmpty($message);
    }

    public function testClose()
    {
        $resource = $this->curlAdaptee->init('');
        $curlAdaptee = $this->curlAdaptee->close($resource);
        $this->assertEquals($curlAdaptee, $this->curlAdaptee);
    }

    public function testAgentString()
    {
        $string = $this->curlAdaptee->getAgentString();
        $this->assertEquals('PHP Curl', substr($string, 0, 8));
    }
}
