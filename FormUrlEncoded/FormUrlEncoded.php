<?php

namespace Fgms\EmailInquiriesBundle\FormUrlEncoded;

/**
 * Contains utilities for working with form encoded
 * data.
 */
class FormUrlEncoded
{
    /**
     * Decodes a form encoded string.
     *
     * @param string $str
     *
     * @return object
     */
    public static function decode($str)
    {
        $retr = new \stdClass();
        if ($str === '') return new ObjectWrapper($retr,$str);
        $split = explode('&',$str);
        foreach ($split as $entry) {
            $kvp = explode('=',$entry);
            if (count($kvp) !== 2) throw new Exception\DecodeException(
                sprintf(
                    'Entry "%s" did not split on "=" into key and value',
                    $entry
                )
            );
            list($key,$value) = $kvp;
            $key = urldecode($key);
            $value = urldecode($value);
            if (!isset($retr->$key)) {
                $retr->$key = $value;
                continue;
            }
            if (!is_array($retr->$key)) {
                $retr->$key = [$retr->$key];
            }
            $retr->$key[] = $value;
        }
        return new ObjectWrapper($retr,$str);
    }
}
