<?php


namespace Rewsam\DevelopmentAssist\Service\Helper;

class StringCaseConversion
{
    public static function camelToWords(string $string): string
    {
        return ucwords(
            preg_replace(
                ["/([A-Z]+)/", "/_([A-Z]+)([A-Z][a-z])/"],
                [" $1", " $1 $2"],
                lcfirst($string)
            )
        );
    }

    public static function camelToDash(string $string): string
    {
        return strtolower(
            preg_replace(
                ["/([A-Z]+)/", "/_([A-Z]+)([A-Z][a-z])/"],
                ["-$1", "-$1-$2"],
                lcfirst($string)
            )
        );
    }

    public static function underscoreToCamel(string $string): string
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        $str[0] = strtolower($str[0]);

        return $str;
    }
}