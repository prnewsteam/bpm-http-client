<?php

namespace Test\Brownie\HttpClient;

use Brownie\HttpClient\HeadList;

class HeadListTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var HeadList
     */
    protected $headList;

    protected function setUp()
    {
        $this->headList = new HeadList("qqq\r\nwww\r\n\r\nttt\r\n");
    }

    protected function tearDown()
    {
        $this->headList = null;
    }

    /**
     * @expectedException \Brownie\Util\Exception\MethodNotImplementedException
     */
    public function testIsSkipHeaderLine()
    {
        $this->headList->get('test');
    }

    /**
     * @expectedException \Brownie\Util\Exception\MethodNotImplementedException
     */
    public function testCreateCollectionItem()
    {
        $this->headList->createCollectionItem('');
    }
}
