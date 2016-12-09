<?php

namespace Fgms\EmailInquiriesBundle\Shopify;

/**
 * A safe wrapper for objects returned from the
 * Shopify API.
 */
class ValueWrapper extends \Fgms\EmailInquiriesBundle\Utility\ValueWrapperDecorator
{
    public function raiseMissing($key)
    {
        try {
            $this->getInner()->raiseMissing($key);
        } catch (\Exception $ex) {
            throw new Exception\MissingException(
                $this->join($key),
                $this->json,
                $ex
            );
        }
    }

    public function raiseTypeMismatch($key, $expected, $actual)
    {
        try {
            $this->getInner()->raiseTypeMismatch($key,$expected,$actual);
        } catch (\Exception $ex) {
            throw new Exception\TypeMismatchException(
                $expected,
                $actual,
                $this->join($key),
                $ex
            );
        }
    }

    public static function create($json)
    {
        //  To guard against PSR-7 streams
        $json = (string)$json;
        try {
            $obj = \Fgms\EmailInquiriesBundle\Json\Json::decodeObject($json);
        } catch (\Fgms\EmailInquiriesBundle\Json\Exception\Exception $ex) {
            throw new Exception\DecodeException(
                sprintf(
                    'Error decoding Shopify JSON response: %s',
                    $json
                ),
                0,
                $ex
            );
        }
        return new self($obj);
    }
}
