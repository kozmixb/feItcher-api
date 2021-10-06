<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Remove unsafe characters from a string
     * 
     * @param string $string
     * @return string
     */
    public static function getSafeString(string $string): string
    {
        $string = preg_replace('/>.*?</s', '><', $string);              // --- remove content between tags
        $string = preg_replace('/<[^>]*>/', '', $string);               // ----- remove HTML TAGs -----

        $string = htmlentities($string, ENT_COMPAT, 'utf-8');

        $forbidden = [
            '/\[.*\]/U',                                                //---- remove and string inbetween brackets
            '/&(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i',
            '/[\x00-\x1F\x7F]/'                                         //---- remove Ascii Control characters
        ];
        $string = preg_replace($forbidden, '', $string);

        $string = trim(preg_replace('/ {2,}/', ' ', $string));
        $string = html_entity_decode($string);
        return $string;
    }
}
