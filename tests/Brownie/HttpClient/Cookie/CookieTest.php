<?php

namespace Test\Brownie\HttpClient\Cookie;

use Brownie\HttpClient\Cookie\Cookie;

class CookieTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Cookie
     */
    protected $cookie;

    protected function setUp()
    {
        $this->cookie = new Cookie();
    }

    protected function tearDown()
    {
        $this->cookie = null;
    }

    public function testSetGetName()
    {
        $name = 'TestCookieName';
        $this->cookie->setName($name);
        $this->assertEquals($name, $this->cookie->getName());
        $this->assertNull($this->cookie->getValue());
        $this->assertEmpty($this->cookie->getExpires());
        $this->assertEmpty($this->cookie->getPath());
        $this->assertEmpty($this->cookie->getDomain());
        $this->assertFalse($this->cookie->getSecure());
        $this->assertFalse($this->cookie->getSecure());
    }

    public function testSetGetValue()
    {
        $value = 'TestCookieValue';
        $this->cookie->setValue($value);
        $this->assertNull($this->cookie->getName());
        $this->assertEquals($value, $this->cookie->getValue());
        $this->assertEmpty($this->cookie->getExpires());
        $this->assertEmpty($this->cookie->getPath());
        $this->assertEmpty($this->cookie->getDomain());
        $this->assertFalse($this->cookie->getSecure());
        $this->assertFalse($this->cookie->getHttponly());
    }

    public function testSetGetExpires()
    {
        $expires = 'Sat, 27-Oct-99 07:43:29 GMT';
        $this->cookie->setExpires($expires);
        $this->assertNull($this->cookie->getName());
        $this->assertNull($this->cookie->getValue());
        $this->assertEquals($expires, $this->cookie->getExpires());
        $this->assertEmpty($this->cookie->getPath());
        $this->assertEmpty($this->cookie->getDomain());
        $this->assertFalse($this->cookie->getSecure());
        $this->assertFalse($this->cookie->getHttponly());
    }

    public function testSetGetPath()
    {
        $path = '/test/';
        $this->cookie->setPath($path);
        $this->assertNull($this->cookie->getName());
        $this->assertNull($this->cookie->getValue());
        $this->assertEmpty($this->cookie->getExpires());
        $this->assertEquals($path, $this->cookie->getPath());
        $this->assertEmpty($this->cookie->getDomain());
        $this->assertFalse($this->cookie->getSecure());
        $this->assertFalse($this->cookie->getHttponly());
    }

    public function testSetGetDomain()
    {
        $domain = '.test.com';
        $this->cookie->setDomain($domain);
        $this->assertNull($this->cookie->getName());
        $this->assertNull($this->cookie->getValue());
        $this->assertEmpty($this->cookie->getExpires());
        $this->assertEmpty($this->cookie->getPath());
        $this->assertEquals($domain, $this->cookie->getDomain());
        $this->assertFalse($this->cookie->getSecure());
        $this->assertFalse($this->cookie->getHttponly());
    }

    public function testSetGetSecure()
    {
        $secure = true;
        $this->cookie->setSecure($secure);
        $this->assertNull($this->cookie->getName());
        $this->assertNull($this->cookie->getValue());
        $this->assertEmpty($this->cookie->getExpires());
        $this->assertEmpty($this->cookie->getPath());
        $this->assertEmpty($this->cookie->getDomain());
        $this->assertTrue($this->cookie->getSecure());
        $this->assertFalse($this->cookie->getHttponly());
    }

    public function testSetGetHttponly()
    {
        $httponly = true;
        $this->cookie->setHttponly($httponly);
        $this->assertNull($this->cookie->getName());
        $this->assertNull($this->cookie->getValue());
        $this->assertEmpty($this->cookie->getExpires());
        $this->assertEmpty($this->cookie->getPath());
        $this->assertEmpty($this->cookie->getDomain());
        $this->assertFalse($this->cookie->getSecure());
        $this->assertTrue($this->cookie->getHttponly());
    }

    public function testToString()
    {
        $name = 'TestCookieName';
        $value = 'TestCookieValue';
        $expires = 'Sat, 27-Oct-99 07:43:29 GMT';
        $path = '/test/';
        $domain = '.test.com';
        $secure = true;
        $httponly = true;
        $this
            ->cookie
            ->setName($name)
            ->setValue($value)
            ->setExpires($expires)
            ->setPath($path)
            ->setDomain($domain)
            ->setSecure($secure)
            ->setHttponly($httponly);
        $this->assertEquals($name, $this->cookie->getName());
        $this->assertEquals($value, $this->cookie->getValue());
        $this->assertEquals($expires, $this->cookie->getExpires());
        $this->assertEquals($path, $this->cookie->getPath());
        $this->assertEquals($domain, $this->cookie->getDomain());
        $this->assertTrue($this->cookie->getSecure());
        $this->assertTrue($this->cookie->getHttponly());
        $this->assertEquals($name . '=' . $value, $this->cookie->toString());
    }
}
