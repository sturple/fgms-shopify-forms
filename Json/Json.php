<?php

namespace Fgms\EmailInquiriesBundle\Json;

/**
 * Contains static methods for working with
 * JSON data.
 */
class Json
{
    private static function check($encode)
    {
        $code = json_last_error();
        if ($code === JSON_ERROR_NONE) return;
        if ($encode) throw new Exception\EncodeException(
            json_last_error_msg(),
            $code
        );
        throw new Exception\DecodeException(
            json_last_error_msg(),
            $code
        );
    }

    public static function encode($value, $options = 0, $depth = 512)
    {
        $retr = json_encode($value,$options,$depth);
        self::check(true);
        return $retr;
    }

    public static function decodeRaw($json, $assoc = false, $depth = 512, $options = 0)
    {
        $retr = json_decode($json,$assoc,$depth,$options);
        self::check(false);
        return $retr;
    }

    public static function decode($json, $assoc = false, $depth = 512, $options = 0)
    {
        $retr = self::decodeRaw($json,$assoc,$depth,$options);
        if (is_array($retr)) return new ArrayWrapper($retr,$json);
        if (is_object($retr)) return new ObjectWrapper($retr,$json);
        return $retr;
    }

    public static function decodeArray($json, $assoc = false, $depth = 512, $options = 0)
    {
        $retr = self::decode($json,$assoc,$depth,$options);
        if (!($retr instanceof ArrayWrapper)) throw new Exception\TypeMismatchException(
            'array',
            $retr,
            '',
            $json
        );
        return $retr;
    }

    public static function decodeStringArray($json, $options = 0)
    {
        $retr = self::decodeArray($json,false,2,$options);
        foreach ($retr as $k => $v) if (!is_string($v)) throw new Exception\TypeMismatchException(
            'string',
            $v,
            $retr->join($k),
            $json
        );
        return $retr;
    }
}
