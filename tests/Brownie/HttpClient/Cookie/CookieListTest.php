<?php

namespace Test\Brownie\HttpClient\Cookie;

use Brownie\HttpClient\Cookie\CookieList;

class CookieListTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetToString()
    {
        $cookieList = new CookieList('Set-Cookie: ckn1=ckv1; path=/; secure' . "\r\n" . 'Hello: Test' . "\r\n" . 'Set-Cookie: ckn2=ckv2; path=/test/; domain=.test.com; httponly');
        $cookies = $cookieList->toArray();
        $cookie = $cookies['ckn2'];
        $this->assertEquals('ckn2', $cookie->getName());
        $this->assertEquals('ckv2', $cookie->getValue());
        $this->assertEmpty($cookie->getExpires());
        $this->assertEquals('/test/', $cookie->getPath());
        $this->assertEquals('.test.com', $cookie->getDomain());
        $this->assertFalse($cookie->getSecure());
        $this->assertTrue($cookie->getHttponly());
        $this->assertEquals('ckn2=ckv2', $cookie->toString());
    }

    public function testToArray1()
    {
        $cookieList = new CookieList('');
        $cookies = $cookieList->toArray();
        $this->assertEquals(array(), $cookies);
    }

    public function testToArray2()
    {
        $cookieList = new CookieList('Zsd: 123' . "\r\n\r\n" . 'Set-Cookie: ckn1=ckv1' . "\r\n" . 'rty: 55');
        $cookies = $cookieList->toArray();
        $this->assertCount(1, $cookies);
    }
}
