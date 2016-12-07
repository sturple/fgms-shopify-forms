<?php

namespace Fgms\EmailInquiriesBundle\Utility;

/**
 * Contains utilities for working with form encoded
 * data.
 */
class Form
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
        if ($str === '') return $retr;
        $split = explode('&',$str);
        foreach ($split as $entry) {
            $kvp = explode('=',$entry);
            if (count($kvp) !== 2) throw new Exception\FormDecodeException(
                sprintf(
                    'Entry "%s" did not split on "=" into key and value',
                    $entry
                )
            );
            list($key,$value) = $kvp;
            $key = rawurldecode($key);
            $value = rawurldecode($value);
            if (!isset($retr->$key)) {
                $retr->$key = $value;
                continue;
            }
            if (!is_array($retr->$key)) {
                $retr->$key = [$retr->$key];
            }
            $retr->$key[] = $value;
        }
        return $retr;
    }
}
