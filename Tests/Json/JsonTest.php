<?php

namespace Fgms\EmailInquiriesBundle\Tests\Json;

class JsonTest extends \PHPUnit_Framework_TestCase
{
    public function testEncode()
    {
        $this->assertSame('[]',\Fgms\EmailInquiriesBundle\Json\Json::encode([]));
    }

    public function testDecode()
    {
        $this->assertSame('aoeu',\Fgms\EmailInquiriesBundle\Json\Json::decode('"aoeu"'));
    }

    public function testDecodeObject()
    {
        $wrapper = \Fgms\EmailInquiriesBundle\Json\Json::decode('{"foo":"bar"}');
        $this->assertSame('bar',$wrapper->getString('foo'));
    }

    public function testDecodeObjectMissing()
    {
        $wrapper = \Fgms\EmailInquiriesBundle\Json\Json::decode('{}');
        $this->expectException(\Fgms\EmailInquiriesBundle\Json\Exception\MissingException::class);
        $wrapper->getString('foo'); //  There is no such key
    }

    public function testDecodeArray()
    {
        $wrapper = \Fgms\EmailInquiriesBundle\Json\Json::decode('["foo",5]');
        $this->assertSame('foo',$wrapper->getString(0));
        $this->assertSame(5,$wrapper->getInteger(1));
    }

    public function testDecodeArrayTypeMismatch()
    {
        $wrapper = \Fgms\EmailInquiriesBundle\Json\Json::decode('[5]');
        $this->expectException(\Fgms\EmailInquiriesBundle\Json\Exception\TypeMismatchException::class);
        $wrapper->getString(0); //  It's actually an integer
    }

    public function testDecodeFail()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Json\Exception\DecodeException::class);
        \Fgms\EmailInquiriesBundle\Json\Json::decode('aoeu');
    }

    public function testDecodeArrayMismatch()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Json\Exception\TypeMismatchException::class);
        \Fgms\EmailInquiriesBundle\Json\Json::decodeArray('{}');
    }

    public function testDecodeObjectMismatch()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Json\Exception\TypeMismatchException::class);
        \Fgms\EmailInquiriesBundle\Json\Json::decodeObject('[]');
    }

    public function testDecodeStringArrayMismatch()
    {
        $this->expectException(\Fgms\EmailInquiriesBundle\Json\Exception\TypeMismatchException::class);
        \Fgms\EmailInquiriesBundle\Json\Json::decodeStringArray('[5]');
    }
}
