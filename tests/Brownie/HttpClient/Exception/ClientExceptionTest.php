<?php

namespace Test\Brownie\HttpClient\Exception;

use Brownie\HttpClient\Exception\ClientException;

class ClientExceptionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \Brownie\HttpClient\Exception\ClientException
     */
    public function testException()
    {
        throw new ClientException('Test');
    }
}
