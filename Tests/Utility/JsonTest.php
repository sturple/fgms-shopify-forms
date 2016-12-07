<?php

namespace Fgms\EmailInquiriesBundle\Tests\Utility;

class JsonTest extends \PHPUnit_Framework_TestCase
{
    public function testEncode()
    {
        $this->assertSame('[]',\Fgms\EmailInquiriesBundle\Utility\Json::encode([]));
    }

    public function testDecode()
    {
        $this->assertSame('aoeu',\Fgms\EmailInquiriesBundle\Utility\Json::decode('"aoeu"'));
    }

    public function testDecodeFail()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Exception\JsonException::class);
        \Fgms\EmailInquiriesBundle\Utility\Json::decode('aoeu');
    }
}
