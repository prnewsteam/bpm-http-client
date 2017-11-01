<?php

namespace Test\Brownie\HttpClient\Exception;

use Brownie\HttpClient\Exception\ValidateException;

class ValidateExceptionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \Brownie\HttpClient\Exception\ValidateException
     */
    public function testException()
    {
        throw new ValidateException('Test');
    }
}
