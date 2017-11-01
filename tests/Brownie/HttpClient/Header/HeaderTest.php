<?php

namespace Test\Brownie\HttpClient\Header;

use Brownie\HttpClient\Header\Header;

class HeaderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Header
     */
    protected $header;

    protected function setUp()
    {
        $this->header = new Header();
    }

    protected function tearDown()
    {
        $this->header = null;
    }

    public function testSetGetName()
    {
        $name = 'TestHeaderName';
        $this->header->setName($name);
        $this->assertEquals($name, $this->header->getName());
        $this->assertNull($this->header->getValue());
    }

    public function testSetGetValue()
    {
        $value = 'TestHeaderValue';
        $this->header->setValue($value);
        $this->assertEquals($value, $this->header->getValue());
        $this->assertNull($this->header->getName());
    }

    public function testSetGetNameValue()
    {
        $name = 'TestHeaderName';
        $value = 'TestHeaderValue';
        $this
            ->header
            ->setName($name)
            ->setValue($value);
        $this->assertEquals($name, $this->header->getName());
        $this->assertEquals($value, $this->header->getValue());
    }

    public function testToStringOk()
    {
        $name = 'TestHeaderName';
        $value = 'TestHeaderValue';
        $this
            ->header
            ->setName($name)
            ->setValue($value);
        $this->assertEquals($name, $this->header->getName());
        $this->assertEquals($value, $this->header->getValue());
        $this->assertEquals($name . ': ' . $value, $this->header->toString());
    }

    public function testToStringError1()
    {
        $name = 'TestHeaderName';
        $this->header->setName($name);
        $this->assertEquals($name, $this->header->getName());
        $this->assertNull($this->header->getValue());
        $this->assertNull($this->header->toString());
    }

    public function testToStringError2()
    {
        $value = 'TestHeaderValue';
        $this->header->setValue($value);
        $this->assertEquals($value, $this->header->getValue());
        $this->assertNull($this->header->getName());
        $this->assertNull($this->header->toString());
    }

    public function testToStringError3()
    {
        $this->assertNull($this->header->getValue());
        $this->assertNull($this->header->getName());
        $this->assertNull($this->header->toString());
    }
}
